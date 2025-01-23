<?php
$basepath = '../../../';
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

try {
    $name = $_POST['name'];
    $grade = $_POST['grade'];
    $pdtInput = $_POST['pdt'] ?? null;
    $leaderInput = $_POST['leader'] ?? null;
    $viceLeaderInput = $_POST['vice_leader'] ?? null;

    function getUserId($input, $userManager)
    {
        if ($input) {
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $userInfo = $userManager->getUserInfo($input, 'email');
                if ($userInfo && isset($userInfo['id'])) {
                    return $userInfo['id'];
                } else {
                    Utils::alert("Usuário de email $input não encontrado.", "../../../dashboard/pages/turmas.php");
                }
            }

            return $input;
        }
        return null;
    }

    $pdtId = getUserId($pdtInput, $userManager);
    $leaderId = getUserId($leaderInput, $userManager);
    $viceLeaderId = getUserId($viceLeaderInput, $userManager);

    $classManager->createClass($name, $grade, $pdtId, $leaderId, $viceLeaderId);
} catch (Exception $e) {
    error_log($e->getMessage());
    Utils::alert("Ocorreu um erro ao criar a turma. Por favor, tente novamente mais tarde.", "../../../dashboard/pages/turmas.php");
    exit();
}
