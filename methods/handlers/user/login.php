<?php
$allowUnauthenticatedAccess = true;
$basepath = "../../../";
require_once "../../bootstrap.php";

$email = $_POST['email'];
$password = $_POST['password'];

$user = $userManager->getInfo($email, 'email', ['name']);
$logger->action(
  $user['id'],
  'login',
  'users',
  $id,
  "'{$user['name']}' logou em sua conta",
  Utils::getIp()
);

$userManager->login($email, $password);
