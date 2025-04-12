<?php
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Navigation::alert('Método inválido', $_SERVER['HTTP_REFERER'], 'error', 'Método Inválido');
    exit;
}

try {
    $id = intval($_GET['id']);
    $deleteStudents = isset($_GET['deleteStudents']) ? true : false;

    $classInfo = $classController->getInfo($id);
    $message = sprintf('Turma deletada: %s (ID %s) ', $classInfo['name'], $classInfo['id']);
    if ($deleteStudents) {
        $students = $classController->getUsers($id, ['lider', 'vice_lider', 'aluno'], ['id', 'name']);
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

    $classController->delete($id, $deleteStudents);

    $_SESSION['alert'][] = [
        'titulo' => 'Sucesso',
        'mensagem' => 'Turma ' . $classInfo['name'] . ' deletada com sucesso',
        'tipo' => 'success'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER'], true);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
