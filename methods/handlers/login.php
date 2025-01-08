<?php
$allowUnauthenticatedAccess = true;
$basepath = '../../';
require_once '../bootstrap.php';

$email = $_POST['email'];
$password = $_POST['password'];

$userManager->login($email, $password);
