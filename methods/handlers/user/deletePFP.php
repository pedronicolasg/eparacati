<?php
$basepath = "../../../";
require_once '../../bootstrap.php';
$id = $_GET['id'];

$profilePage = '../../../perfil.php?id=' . $id . '&editPanel';

if (Utils::show($id) == $_SESSION || $currentUser['role'] == 'gestao') {
  $userManager->deleteUserProfilePhoto(Utils::show($id));
  Utils::redirect($profilePage);
} else {
  Utils::alert('Você não tem permissão para realizar essa ação', $profilePage);
}
