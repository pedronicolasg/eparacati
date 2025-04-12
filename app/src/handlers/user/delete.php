<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Navigation::alert('Método inválido', $_SERVER['HTTP_REFERER'], 'error', 'Método Inválido');
  exit;
}

try {
  $userId = intval($_GET['id']);
  if ($userId === $_SESSION['id']) {
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => 'Você não pode deletar seu próprio usuário',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }

  $user = $userController->getInfo($userId, 'id', ['name']);
  $classController->handleUserDeletion($userId);
  $success = $userController->delete($userId);

  $logger->action(
    $currentUser['id'],
    'delete',
    'users',
    $id,
    "Usuário '" . $user['name'] . "' excluído",
    Security::getIp()
  );

  $_SESSION['alert'][] = [
    'titulo' => 'Sucesso',
    'mensagem' => 'Usuário ' . $user['name'] . ' deletado com sucesso',
    'tipo' => 'success'
  ];
  Navigation::redirect('../../../dashboard/pages/usuarios.php', true);
} catch (Exception $e) {
  Navigation::alert($e->getMessage(), $_SERVER['HTTP_REFERER']);
  exit;
}
