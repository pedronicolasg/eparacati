<?php
require_once('../conn.php');
require_once('../usermanager.php');
$userManager = new UserManager($conn);

$email = $_POST['email'];
$password = $_POST['password'];

$userManager->login($email, $password);
