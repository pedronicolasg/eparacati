<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

if ($id <= 0) {
  Navigation::alert('ID inválido.', 400);
  exit;
}

if (!in_array(strtolower($format), ['json', 'excel'])) {
  Navigation::alert('Formato não suportado. Use "json" ou "excel".', $_SERVER['HTTP_REFERER']);
  exit;
}

try {
  $logger->exportLog($id, $format);
  Navigation::redirect($_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
  Navigation::alert('Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage(), $_SERVER['HTTP_REFERER']);
  exit;
}
