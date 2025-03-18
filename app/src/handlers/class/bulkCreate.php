<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";
$classesPagePath = '../../../dashboard/pages/turmas.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['upload_error'] = "Método inválido";
  Navigation::redirect($classesPagePath);
  exit;
}

try {
  if (!isset($_FILES['excel_file'])) {
    Navigation::alert("Nenhum arquivo enviado", $classesPagePath);
  }

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($_FILES['excel_file']['type'], $allowedTypes)) {
    Navigation::alert("Tipo de arquivo inválido. Use .xlsx ou .xls", $classesPagePath);
  }

  $result = $classController->bulkCreate($_FILES['excel_file']['tmp_name']);

  $_SESSION['upload_success'] = $result['success'];
  $_SESSION['upload_errors'] = $result['errors'];

  $createdClasses = array_map(function($name, $id) {
    return "$name ($id)";
  }, array_keys($result['created_classes']), $result['created_classes']);
  $createdClassesMessage = "Foram adicionadas " . $result['success'] . " novas turmas: " . implode("\n", $createdClasses);

  $logger->action(
  $currentUser['id'],
  'add',
  'classes',
  null,
  $createdClassesMessage,
  ipAddress: Security::getIp()
);

  Navigation::redirect($classesPagePath);
} catch (Exception $e) {
  Navigation::alert($_SESSION['upload_error'] = $e->getMessage(), $classesPagePath);
}
