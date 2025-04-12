<?php
$allowUnauthenticatedAccess = true;
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Navigation::alert('Método inválido', $_SERVER['HTTP_REFERER'], 'error', 'Método Inválido');
  exit;
}

try {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $userController->login($email, $password);

  $user = $userController->getInfo($email, 'email', ['name']);
  $logger->action(
    $user['id'],
    'login',
    'users',
    $id,
    "'{$user['name']}' logou em sua conta",
    Security::getIp()
  );
} catch (Exception $e) {
  Navigation::alert($e->getMessage(), $_SERVER['HTTP_REFERER'], 'error', 'Erro de Login');
  exit;
}
