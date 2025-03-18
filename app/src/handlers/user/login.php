<?php
$allowUnauthenticatedAccess = true;
require_once "../../bootstrap.php";

$email = $_POST['email'];
$password = $_POST['password'];

$user = $userController->getInfo($email, 'email', ['name']);
$logger->action(
  $user['id'],
  'login',
  'users',
  $id,
  "'{$user['name']}' logou em sua conta",
  Security::getIp()
);

$userController->login($email, $password);
