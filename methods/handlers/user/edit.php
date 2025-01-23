<?php
$self = isset($_GET['self']);
$isCurrentUser = false;
$basepath = "../../../";
require_once "../../bootstrap.php";

function editUser($id, $data)
{
  global $userManager;
  $userManager->editUser($id, $data);
  Utils::redirect("../../../perfil.php?id=" . Utils::hide($id));
}

function validateRole($role)
{
  $validRoles = [null, 'aluno', 'professor', 'funcionario', 'gestao'];
  if (!in_array($role, $validRoles)) {
    Utils::alert("Cargo inválido!", "../../../perfil.php?id=" . Utils::hide($_POST['id']));
    exit;
  }
}

$id = $_POST['id'];
$bio = $_POST['bio'];
//$profile_photo = $_FILES['profile_photo'];

if ($_POST['id'] == $_SESSION['id']) {
  $isCurrentUser = true;
}

if ($self && $isCurrentUser) {
  $data = [
    'bio' => $bio,
    //'profile_photo' => $profile_photo
  ];
  editUser($id, $data);
} elseif ($currentUser['role'] == 'gestao') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = isset($_POST['password']) && !empty($_POST['password']) ? Utils::passw($_POST['password']) : null;
  $role = $_POST['role'];
  $class_id = $_POST['class'];

  validateRole($role);

  $data = [
    'name' => $name,
    'email' => $email,
    'password' => $password,
    'role' => $role,
    'class_id' => $class_id,
    //'profile_photo' => $profile_photo,
    'bio' => $bio
  ];
  editUser($id, $data);
} else {
  Utils::alert("Você não possui permissão para editar esse usuário!", '../../../index.php');
  exit;
}
