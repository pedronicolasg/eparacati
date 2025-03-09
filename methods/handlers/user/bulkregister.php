<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";
$usersPagePath = '../../../dashboard/pages/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['upload_error'] = "Método inválido";
  Utils::redirect($usersPagePath);
  exit;
}

try {
  if (!isset($_FILES['excel_file'])) {
    Utils::alert("Nenhum arquivo enviado", $usersPagePath);
  }

  $spreadsheet = $_FILES['excel_file'];

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($spreadsheet['type'], $allowedTypes)) {
    Utils::alert("Tipo de arquivo inválido. Use .xlsx ou .xls", $usersPagePath);
  }

  $result = $userManager->bulkAdd($spreadsheet['tmp_name']);

  $_SESSION['upload_success'] = $result['success'];
  $_SESSION['upload_errors'] = $result['errors'];

  $createdUsers = array_map(function ($name, $id) {
    return "$name ($id)";
  }, array_keys($result['created_users']), $result['created_users']);
  $createdUserMessage = "Foram adicionados " . $result['success'] . " novos equipamentos:\n" . implode("\n", $createdUsers);

  $logger->action(
    $currentUser['id'],
    'add',
    'users',
    null,
    $createdUserMessage,
    Utils::getIp()
  );

  Utils::redirect($usersPagePath);
} catch (Exception $e) {
  Utils::alert($_SESSION['upload_error'] = $e->getMessage(), $usersPagePath);
}
