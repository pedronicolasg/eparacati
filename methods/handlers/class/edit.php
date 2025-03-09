<?php
$basepath = '../../../';
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

$classesPagePath = '../../../dashboard/pages/turmas.php';

try {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $grade = $_POST['grade'];
  $pdtId = $_POST['pdt'] ?? null;
  $leaderId = $_POST['leader'] ?? null;
  $viceLeaderId = $_POST['vice_leader'] ?? null;

  function validateLeaderIds($leaderId, $viceLeaderId, $classId)
  {
    if ($leaderId !== null && $viceLeaderId !== null && $leaderId === $viceLeaderId) {
      Utils::alert('O líder e o vice-líder não podem ser a mesma pessoa.', '../../../dashboard/pages/turmas.php?id=' . Utils::hide($classId));
      exit();
    }
  }

  function checkUserClass($userId, $classId, $role)
  {
    global $userManager;
    if ($userId) {
      $user = $userManager->getInfo($userId, 'id', ['class_id']);
      if ($user['class_id'] != $classId) {
        Utils::alert("O $role selecionado não pertence a esta turma.", '../../../dashboard/pages/turmas.php?id=' . Utils::hide($classId));
      }
    }
  }

  validateLeaderIds($leaderId, $viceLeaderId, $id);
  checkUserClass($leaderId, $id, 'líder');
  checkUserClass($viceLeaderId, $id, 'vice-líder');

  $oldClassInfo = $classManager->getInfo($id);
  $class = $classManager->getInfo($id);
  $oldPdtInfo = ($pdtId !== null && $class['pdt_id'] !== $pdtId) ? $userManager->getInfo($class['pdt_id'], 'id', ['name']) : null;
  $oldLeaderInfo = ($leaderId !== null && $class['leader_id'] !== $leaderId) ? $userManager->getInfo($class['leader_id'], 'id', ['name']) : null;
  $oldViceLeaderInfo = ($viceLeaderId !== null && $class['vice_leader_id'] !== $viceLeaderId) ? $userManager->getInfo($class['vice_leader_id'], 'id', ['name']) : null;

  $classManager->edit($id, $name, $grade, $pdtId, $leaderId, $viceLeaderId);

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
      $oldValue = $userManager->getInfo($oldClassInfo[$field], 'id', ['name'])['name'];
      $newValue = $userManager->getInfo($newClassInfo[$field], 'id', ['name'])['name'];
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
      Utils::getIp()
    );
  }

  $_SESSION['success'] = true;
  Utils::redirect($classesPagePath);
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
