<?php
$requiredRoles = ['gestao'];
require_once "../../bootstrap.php";

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
    $name = $_POST['name'];
    $grade = $_POST['grade'];
    $pdtInput = $_POST['pdt'] ?? null;
    $leaderInput = $_POST['leader'] ?? null;
    $viceLeaderInput = $_POST['vice_leader'] ?? null;

    function getUserId($input, $userModel, $expectedRole)
    {
        if ($input) {
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $userInfo = $userModel->getInfo($input, 'email');
                if ($userInfo && isset($userInfo['id'])) {
                    if ($userInfo['role'] !== $expectedRole) {
                        Navigation::alert(
                            "Usuário Inválido",
                            "Usuário de email $input não possui o cargo esperado de " . Format::roleName($expectedRole, true),
                            "warning",
                            $_SERVER['HTTP_REFERER']
                        );
                        exit();
                    }
                    return $userInfo['id'];
                } else {
                    Navigation::alert(
                        "Usuário não Encontrado",
                        "Usuário de email $input não encontrado.",
                        "warning",
                        $_SERVER['HTTP_REFERER']
                    );
                    exit();
                }
            }

            $userInfo = $userModel->getInfo($input, 'id', ['role']);
            if ($userInfo && $userInfo['role'] !== $expectedRole) {
                Navigation::alert(
                    "Usuário Inválido",
                    "Usuário de ID $input não possui o cargo esperado de " . Format::roleName($expectedRole, true),
                    "warning",
                    $_SERVER['HTTP_REFERER']
                );
                exit();
            }

            return $input;
        }
        return null;
    }

    $pdtId = getUserId($pdtInput, $userModel, 'professor');
    $leaderId = getUserId($leaderInput, $userModel, 'aluno');
    $viceLeaderId = getUserId($viceLeaderInput, $userModel, 'aluno');

    $classModel->create($name, $grade, $pdtId, $leaderId, $viceLeaderId);
    $newClassInfo = $classModel->getInfo($name, 'name', ['name']);
    $logger->action(
        $currentUser['id'],
        'add',
        'classes',
        null,
        sprintf('Nova turma criada: %s (ID %s)', $newClassInfo['name'], $newClassInfo['id']),
        Security::getIp()
    );

    Navigation::alert(
        'Sucesso',
        'Turma criada com sucesso',
        'success',
        $_SERVER['HTTP_REFERER']
    );
} catch (Exception $e) {
    Navigation::alert(
        "Erro na criação da turma",
        $e->getMessage(),
        "error",
        $_SERVER['HTTP_REFERER']
    );
    exit();
}
