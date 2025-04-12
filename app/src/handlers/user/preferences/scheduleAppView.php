<?php
require_once "../../../bootstrap.php";

$userController->updateScheduleAppView($_SESSION['id']);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    http_response_code(200);
    exit();
} else {
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit();
}
