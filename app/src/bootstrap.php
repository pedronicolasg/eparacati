<?php
date_default_timezone_set('America/Fortaleza');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_DIR', dirname(__DIR__));
define('SRC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'src');
define('VENDOR_DIR', dirname(ROOT_DIR) . DIRECTORY_SEPARATOR . 'vendor');

set_include_path(get_include_path() . PATH_SEPARATOR . SRC_DIR);

$basepath ??= dirname($_SERVER['SCRIPT_NAME']);

if (!str_ends_with($basepath, '/')) {
    $basepath .= '/';
}
require_once SRC_DIR . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'conn.php';
require_once VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

$controllers = ['User', 'Class', 'Equipment', 'UI', 'Schedule'];
foreach ($controllers as $controller) {
    require_once SRC_DIR . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . "$controller.php";
}

$utils = ['Logger', 'Security', 'Navigation', 'Format'];
foreach ($utils as $util) {
    require_once SRC_DIR . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . "$util.php";
}

$logger = new Logger($conn);
$userController = new UserController($conn);
$classController = new ClassController($conn);
$equipmentController = new EquipmentController($conn);
$scheduleController = new ScheduleController($conn);
$ui = new UI();

// Em prod será substituido por Cron Jobs
$classController->checkUpgrades();
$scheduleController->cleanPastBookings();

if (!function_exists('setRequiredRoles')) {
    function setRequiredRoles($roles)
    {
        global $requiredRoles;
        $requiredRoles = $roles;
    }
}

$requiredRoles ??= ['aluno', 'lider', 'professor', 'gestao'];

if (!isset($allowUnauthenticatedAccess) || !$allowUnauthenticatedAccess) {
    $currentUser = $userController->verifySession($requiredRoles);
    $theme = $currentUser['website_theme'];
}
