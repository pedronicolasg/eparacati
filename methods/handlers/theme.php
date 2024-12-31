<?php
require_once '../conn.php';
require_once '../usermanager.php';

session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$userManager = new UserManager($conn);
$userManager->toggleTheme($_SESSION['id']);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
