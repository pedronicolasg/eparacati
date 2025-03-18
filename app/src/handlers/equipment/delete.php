<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
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

  Navigation::redirect($_SERVER['HTTP_REFERER'], true);
}
