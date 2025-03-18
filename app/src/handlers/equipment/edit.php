<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $type = $_POST['type'];
  $status = $_POST['status'];
  $description = Security::sanitizeInput($_POST['description']);
  $image = $_FILES['image'];

  function validateType($type)
  {
    $validTypes = ['outro', 'notebook', 'extensao', 'projetor', 'sala'];
    if (!in_array($type, $validTypes)) {
      Navigation::alert("Tipo inválido!", $_SERVER['HTTP_REFERER']);
      exit;
    }
  }

  function validateStatus($status)
  {
    $validStatus = ['disponivel', 'agendado', 'indisponivel'];
    if (!in_array($status, $validStatus)) {
      Navigation::alert("Status inválido!", $_SERVER['HTTP_REFERER']);
      exit;
    }
  }

  validateType($type);
  validateStatus($status);

  $data = [
    'name' => $name,
    'type' => $type,
    'status' => $status,
    'description' => $description
  ];

  if ($image && !empty($image['tmp_name'])) {
    $data['image'] = $image;
  }

  $oldEquipmentInfo = $equipmentController->getInfo($id);
  $equipmentController->edit($id, $data);

  $changes = [];
  $fieldNames = [
    'name' => 'Nome',
    'type' => 'Tipo',
    'status' => 'Status',
    'image' => 'Imagem',
    'description' => 'Descrição'
  ];

  foreach ($data as $field => $newValue) {
    $oldValue = $oldEquipmentInfo[$field];
    if ($field === 'image') {
      if (!empty($newValue['tmp_name'])) {
        if ($oldValue === null) {
          $changes[] = "Imagem adicionada";
        } else {
          $changes[] = "Imagem alterada";
        }
      }
    } else {
      if ($oldValue !== $newValue) {
        $changes[] = "{$fieldNames[$field]}: $oldValue > $newValue";
      }
    }
  }

  if (!empty($changes)) {
    $changeLog = implode("\n", $changes);

    $logger->action(
      $currentUser['id'],
      'update',
      'equipments',
      $id,
      "Equipamento '{$data['name']}' atualizado. Mudanças: \n $changeLog",
      Security::getIp()
    );
  }

  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
