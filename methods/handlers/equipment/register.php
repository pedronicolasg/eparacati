<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $type = $_POST["type"];
  $status = $_POST["status"];
  $description = $_POST["description"];
  $image = $_FILES['image'];

  $result = $equipmentManager->register($name, $type, $status, $description, $image);

  $logger->action(
    $currentUser['id'],
    'create',
    'equipments',
    $result,
    "Equipamento '$name' registrado",
    Utils::getIp()
  );

  Utils::redirect('../../../dashboard/pages/equipamentos.php');
}
