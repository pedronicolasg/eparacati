<?php
$allowUnauthenticatedAccess = true;
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Navigation::alert(
    'Método inválido',
    "",
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}

try {
  $email = $_POST['email'] ?? null;
  $password = $_POST['password'] ?? null;

  if (!$email || !$password) {
    Navigation::alert(
      'Dados Incompletos',
      'Email e senha são obrigatórios.',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  if (!Security::validateEmail($email)) {
    Navigation::alert(
      'Email Inválido',
      'O email enviado é inválido, tente novamente.',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  $email = Security::sanitizeInput($email, 'email');
  $password = Security::passw($password);

  $userModel->login($email, $password);

  $user = $userModel->getInfo($email, 'email', ['name']);
  $logger->action(
    $user['id'],
    'login',
    'users',
    $id,
    "'{$user['name']}' logou em sua conta",
    Security::getIp()
  );
} catch (Exception $e) {
  Navigation::alert(
    'Erro de Login',
    $e->getMessage(),
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}
