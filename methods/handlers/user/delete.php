<?php
$basepath = "../../../";
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

$userId = intval($_GET['id']);

if ($userId === $_SESSION['id']) {
  Utils::alert("Você não pode deletar seu próprio usuário.", "../../../dashboard/pages/usuarios.php");
  die();
}

$user = $userManager->getInfo($userId, 'id', ['name']);
$classManager->handleUserDeletion($userId);
$success = $userManager->delete($userId);

$logger->action(
  $currentUser['id'],
  'delete',
  'users',
  $id,
  "Equipamento '" . $user['name'] . "' excluído",
  Utils::getIp()
);

header('Location: ../../../dashboard/pages/usuarios.php');
