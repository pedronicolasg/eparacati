<?php
require_once 'core/conn.php';

require_once 'controllers/Schedule.php';

require_once 'utils/Security.php';
require_once 'utils/Navigation.php';
require_once 'utils/FileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController
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
    private function getScheduleController()
    {
        return new ScheduleController($this->conn);
    }

    public function verifySession($allowedRoles = null)
    {
        if (!isset($_SESSION["id"])) {
            Navigation::redirectToLogin();
            exit();
        }

        $userInfo = $this->getInfo($_SESSION["id"]);

        if (empty($userInfo) || $allowedRoles !== null && !in_array($userInfo["role"], $allowedRoles)) {
            Navigation::redirectToLogin();
            exit();
        }

        return $userInfo;
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

        if ($identifier !== null && in_array("preferences", $fields)) {
            $this->ensurePreferencesExist($userInfo["id"]);
            $preferencesStmt = $this->conn->prepare("SELECT * FROM preferences WHERE user_id = :user_id");
            $preferencesStmt->execute(["user_id" => $userInfo["id"]]);
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

    public function ensurePreferencesExist($userId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM preferences WHERE user_id = ?");
        $stmt->execute([$userId]);

        if ($stmt->fetchColumn() == 0) {
            $this->createPreferences($userId);
        }
    }

    public function register($name, $email, $phone, $password, $role, $class_id, $alerts = true)
    {
        $security = $this->getSecurity();

        if (empty($name) || empty($email) || empty($password) || empty($role)) {
            if ($alerts) {
                Navigation::alert(
                    "Preencha todos os campos!",
                    "../../../dashboard/pages/usuarios.php",
                    'error',
                    'Erro'
                );
            }
            throw new Exception("Campos obrigatórios não preenchidos");
        }

        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetchColumn()) {
            if ($alerts) {
                Navigation::alert(
                    "Email já cadastrado!",
                    "../../../dashboard/pages/usuarios.php",
                    'error',
                    'Erro'
                );
            }
            throw new Exception("Email já cadastrado");
        }

        $id = $security->generateUniqueId(8, "users");
        $created_at = date("d-m-Y H:i:s");
        $profile_photo = $this->generateDefaultPFP($name);

        try {
            $this->conn->beginTransaction();

            $sql = 'INSERT INTO users (id, name, email, phone, password, role, class_id, profile_photo, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $data = [
                $id,
                $name,
                Security::sanitizeInput($email),
                !empty($phone) ? $phone : null,
                Security::passw($password),
                $role,
                $class_id,
                $profile_photo,
                $created_at
            ];
            $stmt->execute($data);

            $defaultPreferences = self::getDefaultPreferences();
            $preferencesSql = 'INSERT INTO preferences (user_id, ' . implode(', ', array_keys($defaultPreferences)) . ')
                               VALUES (:user_id, :' . implode(', :', array_keys($defaultPreferences)) . ')';
            $preferencesStmt = $this->conn->prepare($preferencesSql);
            $preferencesData = array_merge(['user_id' => $id], $defaultPreferences);
            $preferencesStmt->execute($preferencesData);

            $this->conn->commit();
            return $id;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function bulkAdd($filePath)
    {
        $security = $this->getSecurity();
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            $results = ['success' => 0, 'errors' => [], 'created_users' => []];

            foreach ($rows as $index => $row) {
                try {
                    if (empty($row[0]) || empty($row[1]) || empty($row[3])) {
                        $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
                        continue;
                    }

                    $id = $security->generateUniqueId(8, 'users');
                    $this->register($row[0], $row[1], $row[2] ?? null, $row[3], !empty($row[4]) ? $row[4] : null, !empty($row[5]) ? $row[5] : null, false);

                    $results['success']++;
                    $results['created_users'][$row[0]] = $id;
                } catch (Exception $e) {
                    $results['errors'][] = "Linha " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            return $results;
        } catch (Exception $e) {
            Navigation::alert("Erro ao processar arquivo: " . $e->getMessage(), "../../../dashboard/pages/usuarios.php", 'error', 'Erro');
        }
    }

    public function login($email, $password)
    {
        $email = Security::sanitizeInput($email);
        $password = Security::passw($password);

        $sql = "SELECT id, email, password FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch();

        if ($user) {
            if ($user["password"] === $password) {
                $_SESSION["id"] = $user["id"];

                $path = "../../../index.php";
                Navigation::redirect($path);
            } else {
                $msg = "Senha incorreta!";
                $path = "../../../login.php";
                Navigation::alert($msg, $path, 'error', 'Erro');
            }
        } else {
            $msg = "Email não cadastrado!";
            $path = "../../../login.php";
            Navigation::alert($msg, $path, 'error', 'Erro');
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

    private static function generateDefaultPFP($userName)
    {
        $formatted_name = preg_replace(
            "/[^a-zA-Z]/",
            "",
            str_replace(" ", "", $userName)
        );
        return "https://ui-avatars.com/api/?name=$formatted_name&background=random&color=fff";
    }

    public function updateTheme($userId)
    {
        $userInfo = $this->getInfo($userId, "id", ["preferences"]);

        $currentTheme = $userInfo["preferences"]["theme"] ?? "dark";
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

    private function updateProfilePhoto($imageFile, $userId)
    {
        $fileUploader = $this->getFileUploader();
        $uploadPath = '../../../../public/assets/images/profile_photos/';

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
            $profilePhotoPath = '../../../../public/assets/images/profile_photos/' . $userId . '.webp';

            if (file_exists($profilePhotoPath)) {
                unlink($profilePhotoPath);
            }

            $defaultPFP = $this->generateDefaultPFP($userInfo["name"]);

            $stmt = $this->conn->prepare("UPDATE users SET profile_photo = ? WHERE id = ?");
            $stmt->execute([$defaultPFP, $userId]);
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

    public function delete($id)
    {
        try {
            $this->conn->beginTransaction();
            $scheduleController = $this->getScheduleController();

            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);

            $scheduleController->cancel(['user_id' => $id]);

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            Navigation::alert("Falha ao deletar o usuário: " . $e->getMessage(), $_SERVER['HTTP_REFERER']);
        }
    }
}
