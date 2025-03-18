<?php
$requiredRoles = ["gestao"];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $class_id = $_POST["class"];

    $userController->register($name, $email, $password, $role, $class_id);

    $logger->action(
        $currentUser['id'],
        'add',
        'users',
        $result,
        "Usuário '$name' registrado",
        Security::getIp()
    );

    Navigation::redirect($_SERVER['HTTP_REFERER']);
}
