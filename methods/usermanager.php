<?php
require_once 'conn.php';
require_once 'utils.php';
require_once 'logger.php';

session_start();
class UserManager
{
  private $conn;
  private $logger;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->logger = new Logger($conn);
  }

  public static function verifySession($conn, $redirectPath, $allowedRoles = null)
  {
    session_start();

    if (!isset($_SESSION['id'])) {
      Utils::redirect($redirectPath);
      exit;
    }

    $userManager = new UserManager($conn);
    $userInfo = $userManager->getUserInfo($_SESSION['id']);

    if (empty($userInfo)) {
      Utils::redirect($redirectPath);
      exit;
    }

    if ($allowedRoles !== null && !in_array($userInfo['role'], $allowedRoles)) {
      Utils::redirect($redirectPath);
      exit;
    }

    return $userInfo;
  }


  public function getTheme($userId)
  {
    $stmt = $this->conn->prepare("SELECT website_theme FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
  }





  public function getUserInfo($identifier, $type = 'id')
  {
    $sql = '';
    $params = [];

    if ($type === 'id') {
      $sql = "SELECT id, name, email, role, class_id, profile_photo, website_theme, created_at, updated_at 
                  FROM users 
                  WHERE id = :id";
      $params = ['id' => $identifier];
    } elseif ($type === 'email') {
      $sql = "SELECT id, name, email, role, class_id, profile_photo, website_theme, created_at, updated_at 
                  FROM users 
                  WHERE email = :email";
      $params = ['email' => $identifier];
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ?: [];
  }





  public function toggleTheme($userId)
  {
    $currentTheme = $this->getTheme($userId);
    $newTheme = ($currentTheme === 'light') ? 'dark' : 'light';

    $stmt = $this->conn->prepare("UPDATE users SET website_theme = ? WHERE id = ?");
    $stmt->execute([$newTheme, $userId]);
  }

  public function register($name, $role, $email, $password, $class_id)
  {
    $utils = new Utils($this->conn);
    $id = $utils->generateUniqueId(8, 'users', 'id');
    $created_at = date('d-m-Y H:i:s');
    $formatted_name = preg_replace('/[^a-zA-Z]/', '', str_replace(' ', '', $name));
    $profile_photo = "https://ui-avatars.com/api/?name=$formatted_name&background=random&color=fff";

    if (empty($name) || empty($email) || empty($password)) {
      Utils::alertAndRedirect('Preencha todos os campos!', '../pages/register.page.php');
    }

    $sql = 'SELECT id FROM users WHERE email = ?';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->fetchColumn()) {
      Utils::alertAndRedirect('Email já cadastrado!', './aluno.php');
    } else {
      $sql = 'INSERT INTO users (id, name, email, password, role, class_id, profile_photo, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($sql);
      $data = [$id, $name, Utils::sanitizeInput($email), Utils::passw($password), $role, $class_id, $profile_photo, $created_at];

      if ($stmt->execute($data)) {
        Utils::alertAndRedirect('Usuário cadastrado com sucesso!', './usuarios.php');
      } else {
        Utils::alertAndRedirect('Erro ao cadastrar o usuário, tente novamente.', './usuarios.php');
      }
    }
  }

  public function login($email, $password)
  {
    $email = Utils::sanitizeInput($email);
    $password = Utils::passw($password);

    $sql = "SELECT id, name, email, password, role, class_id, profile_photo FROM users WHERE email = :email";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
      if ($user['password'] === $password) {
        session_start();
        $_SESSION['id'] = $user['id'];
        /*
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['class_id'] = $user['class_id'];
        $_SESSION['profile_photo'] = $user['profile_photo'];
        */

        $path = '../../index.php';
        Utils::redirect($path);
      } else {
        $msg = "Senha incorreta!";
        $path = '../../login.php';
        Utils::alertAndRedirect($msg, $path);
      }
    } else {
      $msg = "Email não cadastrado!";
      $path = '../../login.php';
      Utils::alertAndRedirect($msg, $path);
    }
  }

  public function editUser($id, $name, $email, $password, $role, $class_id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

    $updateFields = [];
    $params = [];

    if ($name !== null && $name !== $currentUser['name']) {
      $updateFields[] = "name = :name";
      $params[':name'] = $name;
      /*$params[':profile_photo'] = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=random&color=fff";
      $updateFields[] = "profile_photo = :profile_photo";*/
    }

    if ($email !== null && $email !== $currentUser['email']) {
      $updateFields[] = "email = :email";
      $params[':email'] = $email;
    }

    if ($password !== null && $password !== '') {
      $updateFields[] = "password = :password";
      $params[':password'] = $password;
    }

    if ($role !== null && $role !== $currentUser['role']) {
      $updateFields[] = "role = :role";
      $params[':role'] = $role;
    }

    if ($class_id !== null && $class_id !== $currentUser['class_id']) {
      $updateFields[] = "class_id = :class_id";
      $params[':class_id'] = $class_id;
    }

    // Só atualiza se mudou algo
    if (empty($updateFields)) {
      return true;
    }

    $updateFields[] = "updated_at = :updated_at";
    $params[':updated_at'] = date('d-m-Y H:i:s');
    $params[':id'] = $id;

    $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);

    // Finaliza a sessão do usuário pelo ID
    $this->terminateSessionById($id);

    return Utils::redirect('../../perfil.php?id=' . Utils::hide($id));
  }

  private function terminateSessionById($userId)
  {
    $sessionPath = ini_get('session.save_path'); // Caminho onde as sessões são armazenadas
    $sessionFiles = scandir($sessionPath);

    foreach ($sessionFiles as $sessionFile) {
      if (strpos($sessionFile, 'sess_') === 0) {
        $sessionData = file_get_contents($sessionPath . DIRECTORY_SEPARATOR . $sessionFile);
        if (str_contains($sessionData, "\"id\";s:" . strlen($userId) . ":\"$userId\";")) {
          unlink($sessionPath . DIRECTORY_SEPARATOR . $sessionFile); // Exclui a sessão
          break;
        }
      }
    }
  }

  public static function logout($redirectPath)
  {
    session_start();
    session_unset();
    session_destroy();
    Utils::redirect($redirectPath);
    exit;
  }

  public function deleteUser($id)
  {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
