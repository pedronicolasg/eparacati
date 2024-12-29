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
      $sql = 'INSERT INTO users (name, email, password, role, class_id, profile_photo, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($sql);
      $data = [$name, Utils::sanitizeInput($email), Crypt::passw($password), $role, $class_id, $profile_photo, $created_at];

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

    $sql = "SELECT id, name, email, password, role, class_id, profile_photo, website_theme, created_at, updated_at FROM users WHERE email=:email AND password=:password";
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
      $_SESSION['website_theme'] = $user['website_theme'];
      $_SESSION['created_at'] = $user['created_at'];
      $_SESSION['updated_at'] = $user['updated_at'];

      $local = '../../index.php';
      header('Location: ' . $local);
    } else {
      header('Location: ../handlers/login.php?error=invalid');
    }
  }

  public static function logout($redirectPath)
  {
    session_destroy();
    header('Location: ' . $redirectPath);
    exit;
  }
}
