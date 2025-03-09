<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $id = $_GET["id"];
  $equipment = $equipmentManager->getInfo($id, ['name']);

  $equipmentManager->delete($id);

  $logger->action(
    $currentUser['id'],
    'delete',
    'equipments',
    $id,
    "Equipamento '" . $equipment['name'] . "' excluído",
    Utils::getIp()
  );

  Utils::redirect('../../../dashboard/pages/equipamentos.php');
}
