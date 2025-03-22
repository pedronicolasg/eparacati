<?php
require_once 'core/conn.php';

require_once 'utils/Security.php';
require_once 'utils/Navigation.php';
require_once 'utils/fileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController
{
    private $conn;
    private $security;
    private $fileUploader;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->security = new Security($conn);
        $this->fileUploader = new FileUploader();
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

    public function getInfo($identifier, $type = "id", $fields = [])
    {
        $defaultFields = ["id"];
        $allowedFields = ["id", "name", "email", "role", "class_id", "profile_photo", "bio", "website_theme", "created_at", "updated_at"];

        if (empty($fields)) {
            $fields = $allowedFields;
        } else {
            $fields = array_intersect($fields, $allowedFields);
            $fields = array_unique(array_merge($defaultFields, $fields));
        }

        $sqlFields = implode(", ", $fields);
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

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function getByRole($role)
    {
        $sql = "SELECT id, name, email, role, class_id, profile_photo, website_theme, created_at, updated_at
                FROM users WHERE role = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register($name, $email, $password, $role, $class_id, $alerts = true)
    {
        $id = $this->security->generateUniqueId(8, "users");
        $created_at = date("d-m-Y H:i:s");
        $profile_photo = $this->generateDefaultPFP($name);

        if (empty($name) || empty($email) || empty($password || empty($role)) && $alerts) {
            Navigation::alert(
                "Preencha todos os campos!",
                "../../../dashboard/pages/usuarios.php"
            );
        }

        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->fetchColumn()) {
            if ($alerts) {
                Navigation::alert(
                    "Email já cadastrado!",
                    "../../../dashboard/pages/usuarios.php"
                );
            }
        } else {
            $sql = 'INSERT INTO users (id, name, email, password, role, class_id, profile_photo, website_theme, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $data = [
                $id,
                $name,
                Security::sanitizeInput($email),
                Security::passw($password),
                $role,
                $class_id,
                $profile_photo,
                'light',
                $created_at,
            ];
            $stmt->execute($data);
        }
    }

    public function bulkAdd($filePath)
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            array_shift($rows);

            $results = ['success' => 0, 'errors' => [], 'created_users' => []];

            foreach ($rows as $index => $row) {
                try {
                    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
                        $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
                        continue;
                    }

                    $id = $this->security->generateUniqueId(8, 'users');
                    $this->register($row[0], $row[1], $row[2], $row[3], !empty($row[4]) ? $row[4] : null, false);

                    $results['success']++;
                    $results['created_users'][$row[0]] = $id;
                } catch (Exception $e) {
                    $results['errors'][] = "Linha " . ($index + 2) . ": " . $e->getMessage();
                }
            }

            return $results;
        } catch (Exception $e) {
            Navigation::alert("Erro ao processar arquivo: " . $e->getMessage());
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
                Navigation::alert($msg, $path);
            }
        } else {
            $msg = "Email não cadastrado!";
            $path = "../../../login.php";
            Navigation::alert($msg, $path);
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
        $userInfo = $this->getInfo($userId, "id", ["website_theme"]);

        $currentTheme = $userInfo["website_theme"];
        $newTheme = $currentTheme === "light" ? "dark" : "light";

        $stmt = $this->conn->prepare(
            "UPDATE users SET website_theme = ? WHERE id = ?"
        );
        $stmt->execute([$newTheme, $userId]);
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
        $uploadPath = '../../../../public/assets/images/profile_photos/';

        $pfpPath = $this->fileUploader->uploadImage(
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
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
