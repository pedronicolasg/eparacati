<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

$userId = intval($_GET['id']);

if ($userId === $_SESSION['id']) {
  Navigation::alert("Você não pode deletar seu próprio usuário.", "../../../dashboard/pages/usuarios.php");
  die();
}

$user = $userController->getInfo($userId, 'id', ['name']);
$classController->handleUserDeletion($userId);
$success = $userController->delete($userId);

$logger->action(
  $currentUser['id'],
  'delete',
  'users',
  $id,
  "Equipamento '" . $user['name'] . "' excluído",
  Security::getIp()
);

Navigation::redirect($_SERVER['HTTP_REFERER'], true);
