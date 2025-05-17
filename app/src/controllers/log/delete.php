<?php
$requiredRoles = ['gestao'];
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
  $id = isset($_GET['id']) ? $_GET['id'] : null;
  if ($id <= 0) {
    if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => 'ID inválido.',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }

  $logger->deactivate($id);
  Navigation::redirect($_SERVER['HTTP_REFERER'], true);
} catch (Exception $e) {
  if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
    'titulo' => 'Erro',
    'mensagem' => 'Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage(),
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}
