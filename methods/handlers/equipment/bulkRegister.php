<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";
$equipmentsPagePath = '../../../dashboard/pages/equipamentos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['upload_error'] = "Método inválido";
  Utils::redirect($equipmentsPagePath);
  exit;
}

try {
  if (!isset($_FILES['excel_file'])) {
    Utils::alert("Nenhum arquivo enviado", $equipmentsPagePath);
  }

  $spreadsheet = $_FILES['excel_file'];

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($spreadsheet['type'], $allowedTypes)) {
    Utils::alert("Tipo de arquivo inválido. Use .xlsx ou .xls", $equipmentsPagePath);
  }

  $equipmentManager->bulkRegister($spreadsheet['tmp_name']);

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
    Utils::getIp()
  );

  Utils::redirect($equipmentsPagePath);
} catch (Exception $e) {
  Utils::alert($_SESSION['upload_error'] = $e->getMessage(), $equipmentsPagePath);
}
