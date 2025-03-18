<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST["name"];
  $type = $_POST["type"];
  $status = $_POST["status"];
  $description = $_POST["description"];
  $image = $_FILES['image'];

  $result = $equipmentController->register($name, $type, $status, $description, $image);

  $logger->action(
    $currentUser['id'],
    'add',
    'equipments',
    $result,
    "Equipamento '$name' registrado",
    Security::getIp()
  );

  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
