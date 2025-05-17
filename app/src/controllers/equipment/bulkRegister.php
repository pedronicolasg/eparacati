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
    Navigation::alert(
      "Nenhum arquivo enviado",
      "",
      "warning",
      $_SERVER['HTTP_REFERER']
    );
  }

  $spreadsheet = $_FILES['excel_file'];

  $allowedTypes = [
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
    'application/vnd.ms-excel' // .xls
  ];

  if (!in_array($spreadsheet['type'], $allowedTypes)) {
        Navigation::alert(
      "Tipo de arquivo inválido",
      "Use .xlsx ou .xls",
      "warning",
      $_SERVER['HTTP_REFERER']
    );
  }

  $result = $equipmentModel->bulkRegister($spreadsheet['tmp_name']);

  $_SESSION['alert'][] = [
    'titulo' => 'Sucesso',
    'mensagem' => $result['success'] . ' Equipamentos adicionados com sucesso',
    'tipo' => 'success'
  ];

  foreach ($result['errors'] as $error) {
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => $error,
      'tipo' => 'error'
    ];
  }

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

  Navigation::redirect($_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
  Navigation::alert(
    "Erro no Upload",
    $_SESSION['upload_error'] = $e->getMessage(),
    "error",
    $_SERVER['HTTP_REFERER']
  );
}
