<?php
$basepath = '../../';
$requiredRoles = ['gestao'];
require_once '../bootstrap.php';

$userId = intval($_GET['id']);
$success = $userManager->deleteUser($userId);
header('Location: ../../dashboard/pages/usuarios.php');
