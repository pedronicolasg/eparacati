<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Navigation::alert(
    'Método inválido',
    "",
    'error',
    $_SERVER['HTTP_REFERER']
  );
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

  $user = $userModel->getInfo($userId, 'id', ['name']);
  $classModel->handleUserDeletion($userId);
  $success = $userModel->delete($userId);

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
  Navigation::alert(
    "Erro ao deletar usuário",
    $e->getMessage(),
    "error",
    $_SERVER['HTTP_REFERER']
  );
  exit;
}
