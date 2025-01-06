<?php
require_once '../conn.php';
require_once '../usermanager.php';
require_once '../utils.php';

UserManager::verifySession('../login.php', ['gestao']);
$userManager = new UserManager($conn);

$userId = intval($_GET['id']);
$success = $userManager->deleteUser($userId);
header('Location: ../../dashboard/pages/usuarios.php');