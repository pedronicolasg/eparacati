<?php
$basepath = "../../../";
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

$logPage = "../../../dashboard/pages/registros.php?id=" . Utils::hide($id);

if ($id <= 0) {
  Utils::alert('ID inválido.', 400);
  exit;
}

if (!in_array(strtolower($format), ['json', 'excel'])) {
  Utils::alert('Formato não suportado. Use "json" ou "excel".', 400);
  exit;
}

try {
  $logger->exportLog($id, $format);
  Utils::redirect($logPage);
} catch (Exception $e) {
  Utils::alert('Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage(), 500);
  exit;
}
