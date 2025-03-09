<?php
$basepath = "../../../";
require_once '../../bootstrap.php';
$id = $_GET['id'];

$profilePage = '../../../perfil.php?id=' . $id . '&editPanel';

if (Utils::show($id) == $_SESSION || $currentUser['role'] == 'gestao') {
  $userManager->deleteProfilePhoto(Utils::show($id));

  if ($currentUser['role'] == 'gestao') {
    $user = $userManager->getInfo(Utils::show($id), 'id', ['name']);
    $logger->action(
      $currentUser['id'],
      'delete',
      'users',
      $id,
      "Foto de perfil de '{$user['name']}' foi excluída",
      Utils::getIp()
    );
  }

  Utils::redirect($profilePage);
} else {
  Utils::alert('Você não tem permissão para realizar essa ação', $profilePage);
}
