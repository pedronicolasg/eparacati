<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

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

  if (!in_array(strtolower($format), ['json', 'excel'])) {
    if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = [
      'titulo' => 'Erro',
      'mensagem' => 'Formato não suportado. Use "json" ou "excel".',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }

  $logger->exportLog($id, $format);
  Navigation::redirect($_SERVER['HTTP_REFERER']);
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
