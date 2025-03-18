<?php
require_once "../../bootstrap.php";
$userController->updateTheme($_SESSION['id']);

Navigation::redirect($_SERVER['HTTP_REFERER']);
exit();
