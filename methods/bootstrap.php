<?php
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED); // Habilitar em prod. !dev
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$basepath = $basepath ?? './';

require_once $basepath . 'methods/conn.php';
require_once $basepath . 'methods/usermanager.php';
require_once $basepath . 'methods/classmanager.php';
require_once $basepath . 'methods/utils.php';
require_once $basepath . 'methods/UI.php';
require_once $basepath . "vendor/autoload.php";

$userManager = new UserManager($conn);
$classManager = new ClassManager($conn);
$classManager->checkClassUpgrades();

if (!function_exists('setRequiredRoles')) {
  function setRequiredRoles($roles) {
    global $requiredRoles;
    $requiredRoles = $roles;
  }
}

$requiredRoles = $requiredRoles ?? ['aluno', 'lider', 'professor', 'gestao'];

if (!isset($allowUnauthenticatedAccess) || !$allowUnauthenticatedAccess) {
  $currentUser = $userManager->verifySession($basepath . 'login.php', $requiredRoles);
  $theme = $currentUser['website_theme'];
}
