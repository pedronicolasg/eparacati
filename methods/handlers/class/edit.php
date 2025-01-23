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
    if (!is_null($leaderId) && !is_null($viceLeaderId) && $leaderId === $viceLeaderId) {
      Utils::alert('O líder e o vice-líder não podem ser a mesma pessoa.', '../../../dashboard/pages/turmas.php?id=' . Utils::hide($classId));
      exit();
    }
  }

  validateLeaderIds($leaderId, $viceLeaderId, $id);

  function checkUserClass($userId, $classId, $role)
  {
    global $userManager;
    if ($userId) {
      $user = $userManager->getUserInfo($userId, 'id', ['class_id']);
      if ($user['class_id'] != $classId) {
        Utils::alert(`O $role selecionado não pertence a esta turma.`, '../../../dashboard/pages/turmas.php?id=' . Utils::hide($classId));
      }
    }
  }

  checkUserClass($leaderId, $id, 'líder');
  checkUserClass($viceLeaderId, $id, 'vice-líder');

  $classManager->editClass($id, $name, $grade, $pdtId, $leaderId, $viceLeaderId);
  $_SESSION['success'] = true;
  Utils::redirect($classesPagePath);
} catch (Exception $e) {
  echo $e->getMessage();
  exit();
}
