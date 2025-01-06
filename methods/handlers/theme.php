<?php
require_once '../conn.php';
require_once '../usermanager.php';
require_once '../utils.php';

$userManager = new UserManager($conn);
UserManager::verifySession('login.php');
$userManager->toggleTheme($_SESSION['id']);

Utils::redirect($_SERVER['HTTP_REFERER']);
exit();
