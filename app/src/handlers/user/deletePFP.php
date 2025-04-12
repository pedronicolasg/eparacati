<?php
require_once '../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Navigation::alert('Método inválido', $_SERVER['HTTP_REFERER'], 'error', 'Método Inválido');
  exit;
}
try {
  $id = $_GET['id'];
  if (Security::show($id) == $_SESSION || $currentUser['role'] == 'gestao') {
    $userController->deleteProfilePhoto(Security::show($id));

    if ($currentUser['role'] == 'gestao') {
      $user = $userController->getInfo(Security::show($id), 'id', ['name']);
      $logger->action(
        $currentUser['id'],
        'delete',
        'users',
        $id,
        "Foto de perfil de '{$user['name']}' foi excluída",
        Security::getIp()
      );
    }

    $_SESSION['alert'][] = [
      'titulo' => 'Sucesso',
      'mensagem' => 'Foto de perfil deletada com sucesso',
      'tipo' => 'success'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  } else {
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => 'Você não tem permissão para realizar essa ação',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }
} catch (Exception $e) {
  Navigation::alert($e->getMessage(), $_SERVER['HTTP_REFERER']);
  exit;
}
