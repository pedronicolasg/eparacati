<?php
$self = isset($_GET['self']);
$isCurrentUser = false;
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Navigation::alert(
    'Método inválido',
    "",
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}

try {
  function editUser($id, $data)
  {
    global $userModel, $self, $currentUser, $logger;

    $bioValue = null;
    if (isset($data['bio'])) {
      $bioValue = Security::sanitizeInput($data['bio']);
      unset($data['bio']);
    }

    if ($bioValue !== null) {
      $data['bio'] = $bioValue;
    }

    $oldUserInfo = $userModel->getInfo($id);

    $userModel->edit($id, $data);

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
        global $classModel;
        $oldClassInfo = $classModel->getInfo($oldValue, 'id', ['name', 'id']);
        $newClassInfo = $classModel->getInfo($newValue, 'id', ['name', 'id']);

        if (!empty($oldClassInfo)) {
          $changes[] = "Turma alterada: " . $oldClassInfo['name'] . " (ID " . $oldClassInfo . ") > " . $newClassInfo['name'] . " (ID " . $newClassInfo['id'] . ")";
        } else {
          $changes[] = "Adicionado a turma: " . $newClassInfo['name'] . " (ID " . $newClassInfo['id'] . ")";
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
        Security::getIp()
      );
    }

    $_SESSION['alert'][] = [
      'titulo' => 'Sucesso',
      'mensagem' => $self ? 'Seu perfil foi atualizado com sucesso' : 'Usuário ' . $data['name'] . ' atualizado com sucesso',
      'tipo' => 'success'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  }

  function validateRole($id, $role)
  {
    global $userModel;
    $userInfo = $userModel->getInfo($id, 'id', ['role']);

    $validRoles = array_merge(
      [null, 'aluno', 'professor', 'funcionario', 'gestao'],
      in_array($userInfo['role'], ['pdt', 'lider', 'vice_lider', 'gremio']) ? [$userInfo['role']] : []
    );

    if (!in_array($role, $validRoles)) {
      $_SESSION['alert'][] = [
        'titulo' => 'Erro',
        'mensagem' => 'Cargo inválido!',
        'tipo' => 'error'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);
      exit;
    }
  }

  $id = $_POST['id'];
  $bio = Security::sanitizeInput($_POST['bio']);
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
    $data['password'] = isset($_POST['password']) && !empty($_POST['password']) ? Security::passw($_POST['password']) : null;

    editUser($id, $data);
  } elseif ($currentUser['role'] == 'gestao') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) && !empty($_POST['password']) ? Security::passw($_POST['password']) : null;
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
    $_SESSION['alert'][] = [
      'titulo' => 'Acesso restrito',
      'mensagem' => 'Você não possui permissão para editar esse usuário!',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }
} catch (Exception $e) {
  Navigation::alert(
    "Erro ao editar Usuário",
    $e->getMessage(),
    "error",
    $_SERVER['HTTP_REFERER']
  );
  exit;
}
