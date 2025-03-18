<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['upload_error'] = "Método inválido";
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}

try {
  if (!isset($_FILES['excel_file'])) {
    Navigation::alert("Nenhum arquivo enviado", $_SERVER['HTTP_REFERER']);
  }

  $spreadsheet = $_FILES['excel_file'];

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($spreadsheet['type'], $allowedTypes)) {
    Navigation::alert("Tipo de arquivo inválido. Use .xlsx ou .xls", $_SERVER['HTTP_REFERER']);
  }

  $equipmentController->bulkRegister($spreadsheet['tmp_name']);

  $_SESSION['upload_success'] = $result['success'];
  $_SESSION['upload_errors'] = $result['errors'];

  $createdEquipments = array_map(function ($name, $id) {
    return "$name ($id)";
  }, array_keys($result['created_equipments']), $result['created_equipments']);
  $createdEquipmentMessage = "Foram adicionados " . $result['success'] . " novos equipamentos:\n" . implode("\n", $createdEquipments);

  $logger->action(
    $currentUser['id'],
    'add',
    'equipments',
    null,
    $createdEquipmentMessage,
    Security::getIp()
  );

  Navigation::redirect($equipmentsPagePath);
} catch (Exception $e) {
  Navigation::alert($_SESSION['upload_error'] = $e->getMessage(), $_SERVER['HTTP_REFERER']);
}
