<?php
require_once 'core/conn.php';

require_once 'models/Schedule.php';

require_once 'utils/Security.php';
require_once 'utils/Navigation.php';
require_once 'utils/FileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class UserModel
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    private function getSecurity()
    {
        return new Security($this->conn);
    }

    private function getFileUploader()
    {
        return new FileUploader();
    }

    private function getScheduleModel()
    {
        return new ScheduleModel($this->conn);
    }

    public function verifySession($allowedRoles = null)
    {
        if (!isset($_SESSION["id"])) {
            Navigation::redirectToLogin();
            exit();
        }

        $userInfo = $this->getInfo($_SESSION["id"]);

        if (empty($userInfo) || $allowedRoles !== null && !in_array($userInfo["role"], $allowedRoles)) {
            session_unset();
            session_destroy();
            Navigation::redirectToLogin();
            exit();
        }

        return $userInfo;
    }

    public function login($email, $password)
    {
        $sql = "SELECT id, email, password FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user["password"] === $password) {
                $_SESSION["id"] = $user["id"];
            } else {
                $msg = "Senha incorreta!";
                $path = "../../../login.php";
                Navigation::alert(
                    'Erro',
                    $msg,
                    "error",
                    $path
                );
            }
        } else {
            $msg = "Email não cadastrado!";
            $path = "../../../login.php";
            Navigation::alert(
                'Erro',
                $msg,
                "error",
                $path
            );
        }
    }

    public static function logout($redirectPath)
    {
        session_start();
        session_unset();
        session_destroy();
        Navigation::redirect($redirectPath);
        exit();
    }

    public function count($filters = [])
    {
        $sql = 'SELECT COUNT(*) FROM users';
        $params = [];

        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $key => $value) {
                $conditions[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getRoles()
    {
        $sql = "SHOW COLUMNS FROM users LIKE 'role'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && preg_match("/^enum\((.*)\)$/", $result['Type'], $matches)) {
            return str_getcsv($matches[1], ',', "'");
        }

        return [];
    }

    public function getInfo($identifier, $type = "id", $fields = [])
    {
        $defaultFields = ["id"];
        $allowedFields = ["id", "name", "email", "phone", "role", "class_id", "profile_photo", "bio", "created_at", "updated_at", "preferences"];

        if (empty($fields)) {
            $fields = $allowedFields;
        } else {
            $fields = array_intersect($fields, $allowedFields);
            $fields = array_unique(array_merge($defaultFields, $fields));
        }

        $sqlFields = implode(", ", array_diff($fields, ["preferences"]));
        $sql = "";
        $params = [];

        if ($type === "id") {
            $sql = "SELECT $sqlFields FROM users WHERE id = :id";
            $params = ["id" => $identifier];
        } elseif ($type === "email") {
            $sql = "SELECT $sqlFields FROM users WHERE email = :email";
            $params = ["email" => $identifier];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        if (in_array("profile_photo", $fields) && (empty($userInfo["profile_photo"]) || !@fopen($userInfo["profile_photo"], 'r'))) {
            $userInfo["profile_photo"] = $this->generateDefaultPFP($userInfo["name"] ?? "User");
        }

        if (!empty($userInfo) && in_array("preferences", $fields)) {
            $this->ensurePreferencesExist($identifier, $type);
            $preferencesStmt = $this->conn->prepare("SELECT * FROM preferences WHERE user_id = :user_id");
            $preferencesStmt->execute(["user_id" => isset($userInfo["id"]) ? $userInfo["id"] : null]);
            $userInfo["preferences"] = $preferencesStmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        return $userInfo;
    }

    public function getByRole($role)
    {
        $sql = "SELECT id, name, email, role, class_id, profile_photo, phone, created_at, updated_at
                FROM users WHERE role = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register($name, $email, $phone, $password, $role, $class_id, $alerts = true)
    {
        $security = $this->getSecurity();
        $usersPagePath = "../../../dashboard/pages/usuarios.php";

        if (empty($name) || empty($email) || empty($password) || empty($role)) {
            if ($alerts) {
                Navigation::alert('Erro', "Preencha todos os campos!", 'error', $usersPagePath);
            }
            return false;
        }

        try {
            $this->conn->beginTransaction();

            $sql = "SELECT id FROM users WHERE email = :email FOR UPDATE";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            if ($stmt->fetchColumn()) {
                $this->conn->rollBack();
                if ($alerts) {
                    Navigation::alert('Erro', "Email já cadastrado!", 'error', $usersPagePath);
                }
                return false;
            }

            $id = $security->generateId();
            $created_at = date("d-m-Y H:i:s");
            $profile_photo = $this->generateDefaultPFP($name);

            $sql = 'INSERT INTO users (id, name, email, phone, password, role, class_id, profile_photo, created_at)
                    VALUES (:id, :name, :email, :phone, :password, :role, :class_id, :profile_photo, :created_at)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $security->sanitizeInput($email, 'email'),
                'phone' => !empty($phone) ? $phone : null,
                'password' => Security::passw($password),
                'role' => $role,
                'class_id' => $class_id,
                'profile_photo' => $profile_photo,
                'created_at' => $created_at
            ]);

            $defaultPreferences = self::getDefaultPreferences();

            $prefKeys = array_keys($defaultPreferences);
            $prefSql = 'INSERT INTO preferences (user_id, ' . implode(', ', $prefKeys) . ')
                        VALUES (:user_id, :' . implode(', :', $prefKeys) . ')';
            $prefStmt = $this->conn->prepare($prefSql);
            $prefStmt->execute(array_merge(['user_id' => $id], $defaultPreferences));

            $this->conn->commit();
            return $id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            if ($alerts) {
                throw $e;
            }
            return false;
        }
    }

    public function bulkAdd($filePath)
    {
        $security = $this->getSecurity();
        $chunkSize = 100;
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            $results = ['success' => 0, 'errors' => [], 'created_users' => []];
            $userData = [];
            $preferenceData = [];

            $roles = $this->getRoles();
            $roleAliases = array_map(function ($role) {
                return \Format::roleName($role);
            }, $roles);
            $roleAliasMap = array_combine(array_map('strtolower', $roleAliases), $roles);

            foreach ($rows as $index => $row) {
                if (empty($row[0]) && empty($row[1]) && empty($row[3]) && empty($row[4]) && empty($row[5])) {
                    continue;
                }
                if (empty($row[0]) || empty($row[1]) || empty($row[3])) {
                    $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
                    continue;
                }

                $rawRole = empty($row[4]) ? 'outro' : strtolower(trim($row[4]));
                $role = isset($roleAliasMap[$rawRole]) ? $roleAliasMap[$rawRole] : $rawRole;

                $id = $security->generateId();
                $userData[] = [
                    'id' => $id,
                    'name' => $row[0],
                    'email' => $security->sanitizeInput($row[1], 'email'),
                    'phone' => !empty($row[2]) ? $row[2] : null,
                    'password' => Security::passw($row[3]),
                    'role' => $role,
                    'class_id' => !empty($row[5]) ? $row[5] : null,
                    'profile_photo' => $this->generateDefaultPFP($row[0]),
                    'created_at' => date("d-m-Y H:i:s")
                ];
                $results['created_users'][$row[0]] = $id;
            }

            $this->conn->beginTransaction();
            $defaultPreferences = self::getDefaultPreferences();
            $prefKeys = array_keys($defaultPreferences);

            foreach (array_chunk($userData, $chunkSize) as $chunk) {
                try {
                    $emails = array_column($chunk, 'email');
                    $placeholders = implode(',', array_fill(0, count($emails), '?'));
                    $sql = "SELECT email FROM users WHERE email IN ($placeholders) FOR UPDATE";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute($emails);
                    $existingEmails = $stmt->fetchAll(PDO::FETCH_COLUMN);

                    if (!empty($existingEmails)) {
                        foreach ($chunk as $index => $data) {
                            if (in_array($data['email'], $existingEmails)) {
                                $results['errors'][] = "Email já cadastrado: " . $data['email'];
                                unset($chunk[$index]);
                            }
                        }
                    }

                    if (empty($chunk)) {
                        continue;
                    }

                    $values = [];
                    $params = [];
                    foreach ($chunk as $index => $data) {
                        $values[] = '(?, ?, ?, ?, ?, ?, ?, ?, ?)';
                        $params = array_merge($params, array_values($data));
                    }
                    $sql = 'INSERT INTO users (id, name, email, phone, password, role, class_id, profile_photo, created_at)
                            VALUES ' . implode(',', $values);
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute($params);

                    $prefValues = [];
                    $prefParams = [];
                    foreach ($chunk as $data) {
                        $prefValues[] = '(:user_id_' . $data['id'] . ', :' . implode('_' . $data['id'] . ', :', $prefKeys) . '_' . $data['id'] . ')';
                        $prefData = array_merge(['user_id_' . $data['id'] => $data['id']], array_combine(
                            array_map(fn($key) => $key . '_' . $data['id'], $prefKeys),
                            array_values($defaultPreferences)
                        ));
                        $prefParams = array_merge($prefParams, $prefData);
                    }
                    $prefSql = 'INSERT INTO preferences (user_id, ' . implode(', ', $prefKeys) . ')
                                VALUES ' . implode(',', $prefValues);
                    $prefStmt = $this->conn->prepare($prefSql);
                    $prefStmt->execute($prefParams);

                    $results['success'] += count($chunk);
                } catch (Exception $e) {
                    $results['errors'][] = "Erro no lote: " . $e->getMessage();
                }
            }

            $this->conn->commit();
            return $results;
        } catch (Exception $e) {
            $this->conn->rollBack();
            Navigation::alert(
                "Erro ao processar arquivo",
                $e->getMessage(),
                'error',
                "../../../dashboard/pages/usuarios.php"
            );
            return $results;
        }
    }

    public function edit($id, $data)
    {
        $currentUser = $this->getInfo($id);

        $updateFields = [];
        $params = [];

        foreach ($data as $field => $value) {
            if ($field === 'profile_photo' && $value !== null) {
                $profilePhotoPath = $this->updateProfilePhoto($value, $id);
                if ($profilePhotoPath) {
                    $updateFields[] = "profile_photo = :profile_photo";
                    $params[":profile_photo"] = $profilePhotoPath;
                } else {
                    $updateFields[] = "profile_photo = :profile_photo";
                    $params[":profile_photo"] = $this->generateDefaultPFP($currentUser['name']);
                }
            } elseif ($field === 'role' && !in_array($value, ['funcionario', 'professor', 'pdt', 'gestao'])) {
                $scheduleModel = $this->getScheduleModel();
                $scheduleModel->cancel(['user_id' => $id]);

                $updateFields[] = "role = :role";
                $params[":role"] = $value;
            } elseif ($value !== null && $value !== $currentUser[$field]) {
                $updateFields[] = "$field = :$field";
                $params[":$field"] = $value;
            }
        }

        if (empty($updateFields)) {
            return true;
        }

        $updateFields[] = "updated_at = :updated_at";
        $params[":updated_at"] = date("d-m-Y H:i:s");
        $params[":id"] = $id;

        $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        try {
            $this->conn->beginTransaction();
            $scheduleModel = $this->getScheduleModel();

            $stmt = $this->conn->prepare("DELETE FROM preferences WHERE user_id = ?");
            $stmt->execute([$id]);


            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);

            $scheduleModel->cancel(['user_id' => $id]);

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            Navigation::alert(
                "Falha ao deletar o usuário",
                $e->getMessage(),
                "error",
                $_SERVER['HTTP_REFERER']
            );
        }
    }

    public function updateRole($userId, $role)
    {
        if ($userId) {
            $stmt = $this->conn->prepare('UPDATE users SET role = ? WHERE id = ?');
            $stmt->execute([$role, $userId]);
        }
    }

    public function updateClass($userId, $classId)
    {
        if ($userId) {
            $stmt = $this->conn->prepare('UPDATE users SET class_id = ? WHERE id = ?');
            $stmt->execute([$classId, $userId]);
        }
    }

    public static function getDefaultPreferences()
    {
        return [
            'theme' => 'light',
            'scheduleAppView' => 'grid'
        ];
    }

    public function createPreferences($userId, $preferences = [])
    {
        $defaultPreferences = self::getDefaultPreferences();
        $preferences = array_merge($defaultPreferences, $preferences);

        $sql = 'INSERT INTO preferences (user_id, ' . implode(', ', array_keys($preferences)) . ')
                VALUES (:user_id, :' . implode(', :', array_keys($preferences)) . ')';
        $stmt = $this->conn->prepare($sql);

        $preferencesData = array_merge(['user_id' => $userId], $preferences);
        $stmt->execute($preferencesData);
    }

    public function ensurePreferencesExist($identifier, $type = "id")
    {
        $userId = $type === "email" ? $this->getInfo($identifier, "email", ["id"])["id"] ?? null : $identifier;

        if ($userId) {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM preferences WHERE user_id = ?");
            $stmt->execute([$userId]);

            if ($stmt->fetchColumn() == 0) {
                $this->createPreferences($userId);
            }
        }
    }

    public function updateTheme($userId, $theme)
    {
        $currentTheme = $theme ?? "dark";
        $newTheme = $currentTheme === "light" ? "dark" : "light";

        $stmt = $this->conn->prepare(
            "UPDATE preferences SET theme = ? WHERE user_id = ?"
        );
        $stmt->execute([$newTheme, $userId]);
    }

    public function updateScheduleAppView($userId)
    {
        $userInfo = $this->getInfo($userId, "id", ["preferences"]);

        $currentView = $userInfo["preferences"]["scheduleAppView"] ?? "grid";
        $newView = $currentView === "grid" ? "list" : "grid";

        $stmt = $this->conn->prepare(
            "UPDATE preferences SET scheduleAppView = ? WHERE user_id = ?"
        );
        $stmt->execute([$newView, $userId]);
    }

    private static function generateDefaultPFP($userName)
    {
        $formatted_name = preg_replace(
            "/[^a-zA-Z]/",
            "",
            str_replace(" ", "", $userName)
        );
        return "https://ui-avatars.com/api/?name=$formatted_name&background=random&color=fff";
    }

    private function updateProfilePhoto($imageFile, $userId)
    {
        $fileUploader = $this->getFileUploader();
        $uploadPath = '../../../../public/images/profile_photos/';

        $pfpPath = $fileUploader->uploadImage(
            $imageFile,
            $uploadPath,
            256,
            256,
            95,
            $userId
        );

        if (isset($pfpPath)) {
            return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/eparacati/' . ltrim($pfpPath, './'); // Remover '/eparacati/' em prod.
        }
    }

    public function deleteProfilePhoto($userId)
    {
        $userInfo = $this->getInfo($userId, "id", ["name", "profile_photo"]);

        if (!empty($userInfo["profile_photo"])) {
            $profilePhotoPath = '../../../../public/images/profile_photos/' . $userId . '.webp';

            if (file_exists($profilePhotoPath)) {
                unlink($profilePhotoPath);
            }

            $defaultPFP = $this->generateDefaultPFP($userInfo["name"]);

            $stmt = $this->conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
            $stmt->execute([$defaultPFP, $userId]);
        }
    }
}
