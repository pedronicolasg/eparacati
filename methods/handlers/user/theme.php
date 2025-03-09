<?php
$basepath = "../../../";
require_once "../../bootstrap.php";
$userManager->updateTheme($_SESSION['id']);

Utils::redirect($_SERVER['HTTP_REFERER']);
exit();
