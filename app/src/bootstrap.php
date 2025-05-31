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

$models = ['User', 'Class', 'Equipment', 'UI', 'Schedule'];
foreach ($models as $controller) {
    require_once SRC_DIR . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . "$controller.php";
}

$utils = ['Logger', 'Security', 'Navigation', 'Format'];
foreach ($utils as $util) {
    require_once SRC_DIR . DIRECTORY_SEPARATOR . 'utils' . DIRECTORY_SEPARATOR . "$util.php";
}

$logger = new Logger($conn);
$userModel = new UserModel($conn);
$classModel = new ClassModel($conn);
$equipmentModel = new EquipmentModel($conn);
$scheduleModel = new ScheduleModel($conn);
$ui = new UI($conn);

// Em prod será substituido por Cron Jobs
$classModel->checkUpgrades();
$scheduleModel->cleanPastBookings();

if (!function_exists('setRequiredRoles')) {
    function setRequiredRoles($roles)
    {
        global $requiredRoles;
        $requiredRoles = $roles;
    }
}

$requiredRoles ??= ['aluno', 'lider', 'funcionario', 'gremio', 'professor', 'pdt', 'gestao'];

if (!isset($allowUnauthenticatedAccess) || !$allowUnauthenticatedAccess) {
    $currentUser = $userModel->verifySession($requiredRoles);
    $currentUserPreferences = $currentUser['preferences'] ?? UserModel::getDefaultPreferences();

    $theme = $currentUserPreferences['theme'];
}
