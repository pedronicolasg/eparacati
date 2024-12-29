<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('America/Sao_Paulo');
require_once('conn.php');
require_once('crypt.php');

$created_at = date('d-m-Y H:i:s');
$name = $_POST['name'];
$role = $_POST['role'];
$email = $_POST['email'];
$password = Crypt::passwcrypt($_POST['password']);
$class_id = $_POST['class_id'];

$formatted_name = preg_replace('/[^a-zA-Z]/', '', str_replace(' ', '', $name));
$profile_photo = "https://ui-avatars.com/api/?name=$formatted_name&background=random&color=fff";

if (empty($name) || empty($email) || empty($password)) {
  $msg = 'Preencha todos os campos!';
  $local = '../pages/register.page.php';
  echo "<meta charset='UTF-8' />";
  echo "<script type=\"text/javascript\">
        alert('$msg');
        location.href='$local';
        </script>";
  exit;
}

$sql = 'SELECT id FROM users WHERE email = ?';
$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$r = $stmt->fetchColumn();

if ($r) {
  $msg = 'Email já cadastrado!';
  $local = './aluno.php';
  echo "<meta charset='UTF-8' />";
  echo "<script type=\"text/javascript\">
        alert('$msg');
        location.href='$local';
        </script>";
  exit;
} else {
  $sql = 'INSERT INTO users (name, email, password, role, class_id, profile_photo, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
  $stmt = $conn->prepare($sql);
  $data = [$name, $email, $password, $role, $class_id, $profile_photo, $created_at];
  $success = $stmt->execute($data);

  if ($success) {
    $msg = 'Usuário cadastrado com sucesso!';
    $local = './usuarios.php';
    echo "<meta charset='UTF-8' />";
    echo "<script type=\"text/javascript\">
            alert('$msg');
            location.href='$local';
            </script>";
    exit;
  } else {
    $msg = 'Erro ao cadastrar o usuário, tente novamente.';
    $local = './usuarios.php';
    echo "<meta charset='UTF-8' />";
    echo "<script type=\"text/javascript\">
            alert('$msg');
            location.href='$local';
            </script>";
    exit;
  }
}
