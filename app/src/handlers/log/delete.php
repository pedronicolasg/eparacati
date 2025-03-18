<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$logsPage = "../../../dashboard/pages/registros.php";

if ($id <= 0) {
  Navigation::alert('ID inválido.', 'error');
  exit;
}

try {
  $logger->deactivate($id);
  Navigation::redirect($_SERVER['HTTP_REFERER'], true);
} catch (Exception $e) {
  Navigation::alert('Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage(), $_SERVER['HTTP_REFERER']);
  exit;
}
