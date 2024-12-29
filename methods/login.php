<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once('conn.php');
require_once('crypt.php');

// Valida/sanitiza entradas e evita um SQL-Injection da vida :)
function sanitize_input($input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

  if (preg_match('/[\'";#\-]/', $input)) {
    die("Entrada inválida detectada.");
  }

  return $input;
}

$email = sanitize_input($_POST['email']);
$password =  Crypt::passwcrypt($_POST['password']);

$sql = "SELECT id, name, email, password, role, class_id, profile_photo, website_theme, created_at, updated_at FROM users WHERE email=:email AND password=:password";
$result = $conn->prepare($sql);
$result->execute(['email' => $email, 'password' => $password]);
$user = $result->fetch();

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

  $local = '../index.php';
  echo "<meta charset='UTF-8' />";
  echo "<script type=\"text/javascript\">

        location.href='$local';
        </script>";
} else {
  header('Location: ../login.php?error=invalid');
}
