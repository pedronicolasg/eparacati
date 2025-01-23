<?php
$basepath = '../../../';
$requiredRoles = ['gestao'];
require_once '../../bootstrap.php';

try {
    $id = intval($_GET['id']);
    $deleteStudents = isset($_GET['deleteStudents']) ? true : false;

    $classManager->deleteClass($id, $deleteStudents);
    header('Location:../../../dashboard/pages/turmas.php');
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
