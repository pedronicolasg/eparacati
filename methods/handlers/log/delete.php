<?php
$basepath = "../../../";
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;

$logsPage = "../../../dashboard/pages/registros.php";

if ($id <= 0) {
  Utils::alert('ID inválido.', 'error');
  exit;
}

try {
  $logger->deactivate($id);
  Utils::redirect($logsPage);
} catch (Exception $e) {
  Utils::alert('Ocorreu um erro ao processar sua solicitação: ' . $e->getMessage(), 'error');
  exit;
}
