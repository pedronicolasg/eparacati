<?php
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Navigation::alert('Método inválido', $_SERVER['HTTP_REFERER'], 'error', 'Método Inválido');
  exit;
}

try {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $grade = $_POST['grade'];
  $pdtId = $_POST['pdt'] ?? null;
  $leaderId = $_POST['leader'] ?? null;
  $viceLeaderId = $_POST['vice_leader'] ?? null;

  function validateLeaderIds($pdtId, $leaderId, $viceLeaderId)
  {
    if (!empty($pdtId) && !empty($leaderId) && $pdtId === $leaderId) {
      Navigation::alert('O PDT e o líder não podem ser a mesma pessoa.', $_SERVER['HTTP_REFERER']);
      exit();
    }
    if (!empty($pdtId) && !empty($viceLeaderId) && $pdtId === $viceLeaderId) {
      Navigation::alert('O PDT e o vice-líder não podem ser a mesma pessoa.', $_SERVER['HTTP_REFERER']);
      exit();
    }
    if (!empty($leaderId) && !empty($viceLeaderId) && $leaderId === $viceLeaderId) {
      Navigation::alert('O líder e o vice-líder não podem ser a mesma pessoa.', $_SERVER['HTTP_REFERER']);
      exit();
    }
  }

  function checkUserClass($userId, $classId, $role)
  {
    global $userController;
    if ($userId) {
      $user = $userController->getInfo($userId, 'id', ['class_id']);
      if ($user['class_id'] != $classId) {
        Navigation::alert("O $role selecionado não pertence a esta turma.", $_SERVER['HTTP_REFERER']);
      }
    }
  }

  validateLeaderIds($pdtId, $leaderId, $viceLeaderId);
  checkUserClass($leaderId, $id, 'líder');
  checkUserClass($viceLeaderId, $id, 'vice-líder');

  $oldClassInfo = $classController->getInfo($id);
  $class = $classController->getInfo($id);
  $oldPdtInfo = ($pdtId !== null && $class['pdt_id'] !== $pdtId) ? $userController->getInfo($class['pdt_id'], 'id', ['name']) : null;
  $oldLeaderInfo = ($leaderId !== null && $class['leader_id'] !== $leaderId) ? $userController->getInfo($class['leader_id'], 'id', ['name']) : null;
  $oldViceLeaderInfo = ($viceLeaderId !== null && $class['vice_leader_id'] !== $viceLeaderId) ? $userController->getInfo($class['vice_leader_id'], 'id', ['name']) : null;

  $classController->edit($id, $name, $grade, $pdtId, $leaderId, $viceLeaderId);

  $fields = [
    'name' => 'Nome',
    'grade' => 'Série',
    'pdt_id' => 'PDT',
    'leader_id' => 'Líder',
    'vice_leader_id' => 'Vice-líder'
  ];

  $changes = [];
  $newClassInfo = [
    'name' => $name,
    'grade' => $grade,
    'pdt_id' => $pdtId,
    'leader_id' => $leaderId,
    'vice_leader_id' => $viceLeaderId
  ];

  foreach ($fields as $field => $label) {
    if ($oldClassInfo[$field] !== $newClassInfo[$field] && in_array($field, ['pdt_id', 'leader_id', 'vice_leader_id'])) {
      $oldValue = $userController->getInfo($oldClassInfo[$field], 'id', ['name'])['name'];
      $newValue = $userController->getInfo($newClassInfo[$field], 'id', ['name'])['name'];
      if ($oldValue !== $newValue) {
        $changes[] = "$label: $oldValue({$oldClassInfo[$field]}) > $newValue({$newClassInfo[$field]})";
      }
    } else {
      if ($oldValue !== $newValue) {
        $changes[] = "$label: $oldClassInfo[$field] > $newClassInfo[$field]";
      }
    }
  }

  if (!empty($changes)) {
    $message = implode("\n", $changes);
    $logger->action(
      $currentUser['id'],
      'update',
      'classes',
      $id,
      $message,
      Security::getIp()
    );
  }

  $_SESSION['alert'][] = [
    'titulo' => 'Sucesso',
    'mensagem' => 'Turma atualizada com sucesso',
    'tipo' => 'success'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
