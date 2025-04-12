<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
    'titulo' => 'Método Inválido',
    'mensagem' => 'Método inválido',
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}

try {
  $id = $_GET["id"];
  $equipment = $equipmentController->getInfo($id, ['name']);

  $equipmentController->delete($id);

  $logger->action(
    $currentUser['id'],
    'delete',
    'equipments',
    $id,
    "Equipamento '" . $equipment['name'] . "' excluído",
    Security::getIp()
  );

  $_SESSION['alert'][] = [
    'titulo' => 'Sucesso',
    'mensagem' => 'Equipamento ' . $equipment['name'] . ' deletado com sucesso',
    'tipo' => 'success'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER'], true);
} catch (Exception $e) {
  if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
    'titulo' => 'Erro',
    'mensagem' => $e->getMessage(),
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}
