<?php
$self = isset($_GET['self']);
$isCurrentUser = false;
$basepath = "../../../";
require_once "../../bootstrap.php";

function editUser($id, $data)
{
  global $userManager, $currentUser, $logger;

  $bioValue = null;
  if (isset($data['bio'])) {
    $bioValue = $data['bio'];
    unset($data['bio']);
  }

  if ($bioValue !== null) {
    $data['bio'] = $bioValue;
  }

  $oldUserInfo = $userManager->getInfo($id);

  $userManager->edit($id, $data);

  $changes = [];
  $fieldNames = [
    'name' => 'Nome',
    'email' => 'Email',
    'role' => 'Cargo',
    'class_id' => 'Classe',
    'bio' => 'Biografia'
  ];

  foreach ($data as $field => $newValue) {
    $oldValue = $oldUserInfo[$field];
    if ($field === 'profile_photo') {
      if (!empty($newValue['tmp_name'])) {
        $changes[] = $oldValue === null ? "Foto de Perfil adicionada" : "Foto de Perfil alterada";
      }
    } elseif ($field === 'class_id') {
      global $classManager;
      $oldClassInfo = $classManager->getInfo($oldValue, 'id', ['name', 'id']);
      $newClassInfo = $classManager->getInfo($newValue, 'id', ['name', 'id']);

      if (!empty($oldClassInfo)) {
        $changes[] = "Turma alterada: " . $oldClassInfo['name'] . " (ID: " . $oldClassInfo . ") > " . $newClassInfo['name'] . " (ID: " . $newClassInfo['id'] . ")";
      } else {
        $changes[] = "Adicionado a turma: " . $newClassInfo['name'] . " (ID: " . $newClassInfo['id'] . ")";
      }
    } elseif ($field === 'password') {
      $changes[] = "Senha alterada";
    } else {
      if ($oldValue !== $newValue) {
        $changes[] = "{$fieldNames[$field]}: $oldValue > $newValue";
      }
    }
  }

  if (!empty($changes)) {
    $changeLog = implode("\n", $changes);

    $logger->action(
      $currentUser['id'],
      'update',
      'users',
      $id,
      "Usuário '{$data['name']}' atualizado. Mudanças: \n $changeLog",
      Utils::getIp()
    );
  }

  Utils::redirect("../../../perfil.php?id=" . Utils::hide($id));
}

function validateRole($id, $role)
{
  global $userManager;
  $userInfo = $userManager->getInfo($id, 'id', ['role']);

  $validRoles = array_merge(
    [null, 'aluno', 'professor', 'funcionario', 'gestao'],
    in_array($userInfo['role'], ['pdt', 'lider', 'vice_lider', 'gremio']) ? [$userInfo['role']] : []
  );

  if (!in_array($role, $validRoles)) {
    Utils::alert("Cargo inválido!", "../../../perfil.php?id=" . Utils::hide($_POST['id']));
    exit;
  }
}

$id = $_POST['id'];
$bio = $_POST['bio'];
$profile_photo = $_FILES['profile_photo'];

if ($_POST['id'] == $_SESSION['id']) {
  $isCurrentUser = true;
}

if ($self && $isCurrentUser) {
  $data = [];
  if ($profile_photo && !empty($profile_photo['tmp_name'])) {
    $data['profile_photo'] = $profile_photo;
  }
  $data['bio'] = $bio;

  editUser($id, $data);
} elseif ($currentUser['role'] == 'gestao') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = isset($_POST['password']) && !empty($_POST['password']) ? Utils::passw($_POST['password']) : null;
  $role = $_POST['role'];
  $class_id = $_POST['class'];

  validateRole($id, $role);

  $data = [
    'name' => $name,
    'email' => $email,
    'role' => $role
  ];

  if ($password !== null) {
    $data['password'] = $password;
  }

  if (!in_array($role, ['lider', 'vice_lider', 'pdt'])) {
    $data['class_id'] = $class_id;
  }

  if ($profile_photo && !empty($profile_photo['tmp_name'])) {
    $data['profile_photo'] = $profile_photo;
  }

  $data['bio'] = $bio;

  editUser($id, $data);
} else {
  Utils::alert("Você não possui permissão para editar esse usuário!", '../../../index.php');
  exit;
}
