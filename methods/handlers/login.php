<?php
require_once('../conn.php');
require_once('../usermanager.php');

$userManager = new UserManager($conn);

$userManager->login($_POST['email'], $_POST['password']);


