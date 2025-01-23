<?php
$basepath = "../../../";
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $class_id = $_POST["class"];

    $userManager->register($name, $email, $password, $role, $class_id);
    Utils::redirect('../../../dashboard/pages/usuarios.php');
}
