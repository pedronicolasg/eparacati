<?php
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Navigation::alert(
        'Método inválido',
        "",
        'error',
        $_SERVER['HTTP_REFERER']
    );
    exit;
}

try {
    $id = intval($_GET['id']);
    $deleteStudents = isset($_GET['deleteStudents']) ? true : false;

    $classInfo = $classModel->getInfo($id);
    $message = sprintf('Turma deletada: %s (ID %s) ', $classInfo['name'], $classInfo['id']);
    if ($deleteStudents) {
        $students = $classModel->getUsers($id, ['lider', 'vice_lider', 'aluno'], ['id', 'name']);
        $sessionMessage = $message . " e todos os seus " . count($students) . ' alunos.';
        $message .= " e todos os seus alunos: \n";
        foreach ($students as $student) {
            $message .= sprintf('%s (ID %s)' . "\n", $student['name'], $student['id']);
        }
    }
    $logger->action(
        $currentUser['id'],
        'delete',
        'classes',
        $id,
        $message,
        Security::getIp()
    );

    $classModel->delete($id, $deleteStudents);

    $_SESSION['alert'][] = [
        'titulo' => 'Sucesso',
        'mensagem' => $sessionMessage,
        'tipo' => 'success'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER'], true);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
