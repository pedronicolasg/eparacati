<?php
session_start();
$basepath = $basepath ?? './';

require_once $basepath . 'methods/conn.php';
require_once $basepath . 'methods/usermanager.php';
require_once $basepath . 'methods/utils.php';
require_once $basepath . 'methods/UI.php';

$userManager = new UserManager($conn);

if (!isset($allowUnauthenticatedAccess) || !$allowUnauthenticatedAccess) {
  $requiredRoles = $requiredRoles ?? ['aluno', 'lider', 'professor', 'gestao'];
  $currentUser = $userManager->verifySession($basepath . 'login.php', $requiredRoles);

  $theme = $currentUser['website_theme'];
}
