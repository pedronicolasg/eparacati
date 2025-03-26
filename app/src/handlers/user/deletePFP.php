<?php
require_once '../../bootstrap.php';
$id = $_GET['id'];

$profilePage = '../../../perfil.php?id=' . $id . '&editPanel';

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

  Navigation::redirect($_SERVER['HTTP_REFERER']);
} else {
  Navigation::alert('Você não tem permissão para realizar essa ação', $_SERVER['HTTP_REFERER']);
}
