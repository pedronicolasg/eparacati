<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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
  $name = $_POST["name"];
  $type = $_POST["type"];
  $status = $_POST["status"];
  $description = $_POST["description"];
  $image = $_FILES['image'];

  $result = $equipmentModel->register($name, $type, $status, $description, $image);

  $logger->action(
    $currentUser['id'],
    'add',
    'equipments',
    $result,
    "Equipamento '$name' registrado",
    Security::getIp()
  );

  $_SESSION['alert'][] = [
    'titulo' => 'Sucesso',
    'mensagem' => "Equipamento '$name' registrado com sucesso",
    'tipo' => 'success'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
  if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
    'titulo' => 'Erro ao Registrar',
    'mensagem' => $e->getMessage(),
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}
