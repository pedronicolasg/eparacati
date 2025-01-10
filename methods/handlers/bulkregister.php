<?php
$basepath = "../../";
$requiredRoles = ["gestao"];
require_once '../bootstrap.php';
$usersPagePath = '../../dashboard/pages/usuarios.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['upload_error'] = "Método inválido";
  Utils::redirect($usersPagePath);
  exit;
}

try {
  if (!isset($_FILES['excel_file'])) {
    Utils::alert("Nenhum arquivo enviado", $usersPagePath);
  }

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($_FILES['excel_file']['type'], $allowedTypes)) {
    Utils::alert("Tipo de arquivo inválido. Use .xlsx ou .xls", $usersPagePath);
  }

  $result = $userManager->bulkAddUsers($_FILES['excel_file']['tmp_name']);

  $_SESSION['upload_success'] = $result['success'];
  $_SESSION['upload_errors'] = $result['errors'];

  Utils::redirect($usersPagePath);
} catch (Exception $e) {
  Utils::alert($_SESSION['upload_error'] = $e->getMessage(), $usersPagePath);
}
