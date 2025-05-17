<?php
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Navigation::alert(
    'Método inválido',
    "",
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}

try {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $grade = $_POST['grade'];
  $pdtId = !empty($_POST['pdt']) && $_POST['pdt'] !== '0' ? $_POST['pdt'] : null;
  $leaderId = !empty($_POST['leader']) && $_POST['leader'] !== '0' ? $_POST['leader'] : null;
  $viceLeaderId = !empty($_POST['vice_leader']) && $_POST['vice_leader'] !== '0' ? $_POST['vice_leader'] : null;

  function validateLeaderIds($pdtId, $leaderId, $viceLeaderId)
  {
    if (!empty($pdtId) && !empty($leaderId) && $pdtId === $leaderId) {
      Navigation::alert(
        'Erro',
        'O PDT e o líder não podem ser a mesma pessoa.',
        'warning',
        $_SERVER['HTTP_REFERER']
      );
      exit();
    }
    if (!empty($pdtId) && !empty($viceLeaderId) && $pdtId === $viceLeaderId) {
      Navigation::alert(
        'Erro',
        'O PDT e o vice-líder não podem ser a mesma pessoa.',
        'warning',
        $_SERVER['HTTP_REFERER']
      );
      exit();
    }
    if (!empty($leaderId) && !empty($viceLeaderId) && $leaderId === $viceLeaderId) {
      Navigation::alert(
        'Erro',
        'O líder e o vice-líder não podem ser a mesma pessoa.',
        'warning',
        $_SERVER['HTTP_REFERER']
      );
      exit();
    }
  }

  function checkUserClass($userId, $classId, $role)
  {
    global $userModel;
    if ($userId) {
      $user = $userModel->getInfo($userId, 'id', ['class_id']);
      if ($user['class_id'] != $classId) {
        Navigation::alert(
          "Usuário Inválido",
          "O " . $user['name'] .  "selecionado não pertence a esta turma.",
          "warning",
          $_SERVER['HTTP_REFERER']
        );
      }
    }
  }

  validateLeaderIds($pdtId, $leaderId, $viceLeaderId);
  checkUserClass($leaderId, $id, 'líder');
  checkUserClass($viceLeaderId, $id, 'vice-líder');

  $oldClassInfo = $classModel->getInfo($id);
  $class = $classModel->getInfo($id);
  $oldPdtInfo = ($pdtId !== null && $class['pdt_id'] !== $pdtId) ? $userModel->getInfo($class['pdt_id'], 'id', ['name']) : null;
  $oldLeaderInfo = ($leaderId !== null && $class['leader_id'] !== $leaderId) ? $userModel->getInfo($class['leader_id'], 'id', ['name']) : null;
  $oldViceLeaderInfo = ($viceLeaderId !== null && $class['vice_leader_id'] !== $viceLeaderId) ? $userModel->getInfo($class['vice_leader_id'], 'id', ['name']) : null;

  $classModel->edit($id, $name, $grade, $pdtId, $leaderId, $viceLeaderId);

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
    if ($oldClassInfo[$field] !== $newClassInfo[$field]) {
      if (in_array($field, ['pdt_id', 'leader_id', 'vice_leader_id'])) {
        $oldValue = $oldClassInfo[$field] ? $userModel->getInfo($oldClassInfo[$field], 'id', ['name'])['name'] : 'Nenhum';
        $newValue = $newClassInfo[$field] ? $userModel->getInfo($newClassInfo[$field], 'id', ['name'])['name'] : 'Nenhum';
        $changes[] = "$label: $oldValue > $newValue";
      } else {
        $changes[] = "$label: {$oldClassInfo[$field]} > {$newClassInfo[$field]}";
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

  Navigation::alert(
    'Sucesso',
    'Turma atualizada com sucesso',
    'success',
    $_SERVER['HTTP_REFERER']
  );
} catch (Exception $e) {
  Navigation::alert(
    "Erro na atualização da turma",
    $e->getMessage(),
    "error",
    $_SERVER['HTTP_REFERER']
  );
  exit();
}
