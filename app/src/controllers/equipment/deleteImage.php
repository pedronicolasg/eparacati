<?php
$requiredRoles = ["gestao"];
require_once '../../bootstrap.php';

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  $response = [
    'success' => false,
    'message' => 'Método inválido'
  ];
  
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = [
      'titulo' => 'Método Inválido',
      'mensagem' => 'Método inválido',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  }
  exit;
}

try {
  $id = Security::show($_GET["id"]);
  $equipment = $equipmentModel->getInfo($id, ['name']);

  $equipmentModel->deleteImage($id);

  $logger->action(
    $currentUser['id'],
    'delete',
    'equipments',
    $id,
    "Imagem do equipamento '{$equipment['name']}' foi excluída",
    Security::getIp()
  );

  $response = [
    'success' => true,
    'message' => 'Imagem do equipamento deletada com sucesso'
  ];

  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    $_SESSION['alert'][] = [
      'titulo' => 'Sucesso',
      'mensagem' => 'Imagem do equipamento deletada com sucesso',
      'tipo' => 'success'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  }
} catch (Exception $e) {
  $response = [
    'success' => false,
    'message' => $e->getMessage()
  ];

  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => $e->getMessage(),
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  }
  exit;
}
