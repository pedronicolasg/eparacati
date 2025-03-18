<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

try {
    $name = $_POST['name'];
    $grade = $_POST['grade'];
    $pdtInput = $_POST['pdt'] ?? null;
    $leaderInput = $_POST['leader'] ?? null;
    $viceLeaderInput = $_POST['vice_leader'] ?? null;

    function getUserId($input, $userController, $expectedRole)
    {
        if ($input) {
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $userInfo = $userController->getInfo($input, 'email');
                if ($userInfo && isset($userInfo['id'])) {
                    if ($userInfo['role'] !== $expectedRole) {
                        Navigation::alert("Usuário de email $input não possui o cargo esperado de " . Format::roleName($expectedRole, true), $_SERVER['HTTP_REFERER']);
                        exit();
                    }
                    return $userInfo['id'];
                } else {
                    Navigation::alert("Usuário de email $input não encontrado.", $_SERVER['HTTP_REFERER']);
                    exit();
                }
            }

            $userInfo = $userController->getInfo($input, 'id', ['role']);
            if ($userInfo && $userInfo['role'] !== $expectedRole) {
                Navigation::alert("Usuário de ID $input não possui o cargo esperado de " . Format::roleName($expectedRole, true), $_SERVER['HTTP_REFERER']);
                exit();
            }

            return $input;
        }
        return null;
    }

    $pdtId = getUserId($pdtInput, $userController, 'professor');
    $leaderId = getUserId($leaderInput, $userController, 'aluno');
    $viceLeaderId = getUserId($viceLeaderInput, $userController, 'aluno');

    $classController->create($name, $grade, $pdtId, $leaderId, $viceLeaderId);
    $newClassInfo = $classController->getInfo($name, 'name', ['name']);
    $logger->action(
        $currentUser['id'],
        'add',
        'classes',
        null,
        sprintf('Nova turma criada: %s (ID %s)', $newClassInfo['name'], $newClassInfo['id']),
        Security::getIp()
    );

    Navigation::redirect($classesPagePath);
} catch (Exception $e) {
    error_log($e->getMessage());
    Navigation::alert("Ocorreu um erro ao criar a turma. Por favor, tente novamente mais tarde.", $_SERVER['HTTP_REFERER']);
    exit();
}
