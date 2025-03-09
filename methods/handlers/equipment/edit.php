<?php
$requiredRoles = ['gestao'];
$basepath = "../../../";
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $type = $_POST['type'];
  $status = $_POST['status'];
  $description = $_POST['description'];
  $image = $_FILES['image'];

  $equipmentPage = "../../../dashboard/pages/equipamentos.php?id=" . Utils::hide($id);

  function validateType($type)
  {
    global $equipmentPage;
    $validTypes = ['outro', 'notebook', 'extensao', 'projetor', 'sala'];
    if (!in_array($type, $validTypes)) {
      Utils::alert("Tipo inválido!", $equipmentPage);
      exit;
    }
  }

  function validateStatus($status)
  {
    global $equipmentPage;
    $validStatus = ['disponivel', 'agendado', 'indisponivel'];
    if (!in_array($status, $validStatus)) {
      Utils::alert("Status inválido!", $equipmentPage);
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

  $oldEquipmentInfo = $equipmentManager->getInfo($id);
  $equipmentManager->edit($id, $data);

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
      Utils::getIp()
    );
  }

  Utils::redirect($equipmentPage);
}
