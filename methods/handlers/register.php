<?php
require_once('../conn.php');
require_once('../usermanager.php');

$userManager = new UserManager($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $role = $_POST['role'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $class_id = $_POST['class_id'];

  $userManager->register($name, $role, $email, $password, $class_id);
}
