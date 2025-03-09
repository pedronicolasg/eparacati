<?php
$basepath = '../../../';
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

try {
    $id = intval($_GET['id']);
    $deleteStudents = isset($_GET['deleteStudents']) ? true : false;

    $classInfo = $classManager->getInfo($id);
    $message = sprintf('Turma deletada: %s (ID: %s) ', $classInfo['name'], $classInfo['id']);
    if ($deleteStudents) {
        $students = $classManager->getUsers($id, ['lider', 'vice_lider', 'aluno'], ['id', 'name']);
        $message .= " e todos os seus alunos: \n";
        foreach ($students as $student) {
            $message .= sprintf('%s (ID: %s)' . "\n", $student['name'], $student['id']);
        }
    }
    $logger->action(
        $currentUser['id'],
        'delete',
        'classes',
        $id,
        $message,
        Utils::getIp()
    );

    $classManager->delete($id, $deleteStudents);
    header('Location:../../../dashboard/pages/turmas.php');
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
