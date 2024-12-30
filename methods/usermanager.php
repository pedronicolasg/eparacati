<?php
require_once 'conn.php';
require_once 'crypt.php';
require_once 'utils.php';

session_start();
class UserManager
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }
  public function getTheme($userId)
  {
    $stmt = $this->conn->prepare("SELECT website_theme FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchColumn();
  }

  public function toggleTheme($userId)
  {
    $currentTheme = $this->getTheme($userId);
    $newTheme = ($currentTheme === 'light') ? 'dark' : 'light';

    $stmt = $this->conn->prepare("UPDATE users SET website_theme = ? WHERE id = ?");
    $stmt->execute([$newTheme, $userId]);
  }

  public static function verifySession($redirectPath, $allowedRoles = null)
  {
    if (!isset($_SESSION['id'])) {
      header('Location: ' . $redirectPath);
      exit;
    }

    if ($allowedRoles !== null && !in_array($_SESSION['role'], $allowedRoles)) {
      header('Location: ' . $redirectPath);
      exit;
    }
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
      $data = [$id, $name, Utils::sanitizeInput($email), Crypt::passw($password), $role, $class_id, $profile_photo, $created_at];

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
    $password = Crypt::passw($password);

    $sql = "SELECT id, name, email, password, role, class_id, profile_photo FROM users WHERE email=:email AND password=:password";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch();

    if (!empty($user)) {
      session_start();
      $_SESSION['id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['class_id'] = $user['class_id'];
      $_SESSION['profile_photo'] = $user['profile_photo'];

      $local = '../../index.php';
      header('Location: ' . $local);
    } else {
      header('Location: ../handlers/login.php?error=invalid');
    }
  }

  public function editUser($id, $name, $email, $password, $role, $class_id)
  {
    $updated_at = date('d-m-Y H:i:s');
    $profile_photo = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=random&color=fff";

    $sql = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, class_id = :class_id, profile_photo = :profile_photo, updated_at = :updated_at WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->bindParam(':profile_photo', $profile_photo);
    $stmt->bindParam(':updated_at', $updated_at);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }


  public static function logout($redirectPath)
  {
    session_destroy();
    header('Location: ' . $redirectPath);
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
