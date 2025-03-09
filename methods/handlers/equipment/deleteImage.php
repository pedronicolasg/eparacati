<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once '../../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $id = Utils::show($_GET["id"]);
  $equipment = $equipmentManager->getInfo($id, ['name']);

  $equipmentManager->deleteImage($id);

  $logger->action(
    $currentUser['id'],
    'delete',
    'equipments',
    $id,
    "Imagem do equipamento '{$equipment['name']}' foi excluída",
    Utils::getIp()
  );

  Utils::redirect('../../../dashboard/pages/equipamentos.php');
}
