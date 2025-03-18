<?php
$requiredRoles = ["gestao"];
require_once '../../bootstrap.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $id = Security::show($_GET["id"]);
  $equipment = $equipmentController->getInfo($id, ['name']);

  $equipmentController->deleteImage($id);

  $logger->action(
    $currentUser['id'],
    'delete',
    'equipments',
    $id,
    "Imagem do equipamento '{$equipment['name']}' foi excluída",
    Security::getIp()
  );

  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
