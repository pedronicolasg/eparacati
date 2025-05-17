<?php
$allowUnauthenticatedAccess = true;
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

$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'gestao'");
$stmt->execute();
$gestaoCount = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM setupKeys WHERE active = 1");
$stmt->execute();
$availableKeysCount = $stmt->fetchColumn();

if ($gestaoCount > 0 || $availableKeysCount == 0) {
  Navigation::redirect('../../../login.php');
  exit;
}

try {
  $activationKey = Security::sanitizeInput($_POST["activation-key"]);

  $stmt = $conn->prepare("SELECT id FROM setupKeys WHERE `key` = ? AND active = 1");
  $stmt->execute([$activationKey]);
  $keyId = $stmt->fetchColumn();

  if (!$keyId) {
    Navigation::alert(
      'Chave Inválida',
      'Chave de ativação inválida ou já utilizada',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  $name = Security::sanitizeInput($_POST["name"]);
  $email = Security::sanitizeInput($_POST["email"], 'email');
  $phone = $_POST["phone"];
  $password = $_POST["password"];
  $bio = isset($_POST["bio"]) ? Security::sanitizeInput($_POST["bio"]) : null;
  $profilePhoto = isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['tmp_name']) ? $_FILES['profile_photo'] : null;

  if (empty($name) || empty($email) || empty($phone) || empty($password)) {
    Navigation::alert(
      'Dados Incompletos',
      'Todos os campos obrigatórios devem ser preenchidos',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  if (!Security::isStrongPassword($password)) {
    Navigation::alert(
      'Senha Fraca',
      'A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  $userId = $userModel->register($name, $email, $phone, $password, 'gestao', null);

  if ($bio !== null || $profilePhoto !== null) {
    $updateData = [];

    if ($bio !== null) {
      $updateData['bio'] = $bio;
    }

    if ($profilePhoto !== null) {
      $updateData['profile_photo'] = $profilePhoto;
    }

    if (!empty($updateData)) {
      $userModel->edit($userId, $updateData);
    }
  }

  $importResults = [];

  if (isset($_FILES['users_file']) && !empty($_FILES['users_file']['tmp_name'])) {
    $usersFile = $_FILES['users_file'];
    $allowedTypes = [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
      'application/vnd.ms-excel' // .xls
    ];

    if (in_array($usersFile['type'], $allowedTypes)) {
      $result = $userModel->bulkAdd($usersFile['tmp_name']);
      $importResults['users'] = $result;
    }
  }

  if (isset($_FILES['classes_file']) && !empty($_FILES['classes_file']['tmp_name'])) {
    $classesFile = $_FILES['classes_file'];
    $allowedTypes = [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
      'application/vnd.ms-excel' // .xls
    ];

    if (in_array($classesFile['type'], $allowedTypes)) {
      $result = $classModel->bulkCreate($classesFile['tmp_name']);
      $importResults['classes'] = $result;
    }
  }

  if (isset($_FILES['equipment_file']) && !empty($_FILES['equipment_file']['tmp_name'])) {
    $equipmentFile = $_FILES['equipment_file'];
    $allowedTypes = [
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
      'application/vnd.ms-excel' // .xls
    ];

    if (in_array($equipmentFile['type'], $allowedTypes)) {
      $result = $equipmentModel->bulkRegister($equipmentFile['tmp_name']);
      $importResults['equipment'] = $result;
    }
  }

  $usersAdded = isset($importResults['users']['success']) ? $importResults['users']['success'] : 0;
  $classesAdded = isset($importResults['classes']['success']) ? $importResults['classes']['success'] : 0;
  $equipmentsAdded = isset($importResults['equipment']['success']) ? $importResults['equipment']['success'] : 0;

  $logger->action(
    $userId,
    'setup',
    'system',
    null,
    "Configuração inicial concluída: {$usersAdded} usuários, {$classesAdded} turmas, {$equipmentsAdded} equipamentos importados. Chave de ativação utilizada.",
    Security::getIp()
  );

  $stmt = $conn->prepare("UPDATE setupKeys SET active = 0, used_by_id = ?, used_at = NOW() WHERE id = ?");
  $stmt->execute([$userId, $keyId]);

  sleep(120);

  $userModel->login($email, Security::passw($password));
  Navigation::alert(
    'Bem-vindo ao EP Aracati',
    'Configuração inicial concluída com sucesso!',
    'success',
    '../../../dashboard/index.php'
  );
} catch (Exception $e) {
  Navigation::alert(
    'Erro na Configuração',
    $e->getMessage(),
    'error',
    $_SERVER['HTTP_REFERER'],
  );
  exit;
}
