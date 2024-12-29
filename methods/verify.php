<?php
session_start();
function verification($path, $allowedRoles = null)
{
    if (!isset($_SESSION['id'])) {
        header('Location: ' . $path);
        exit;
    }

    if ($allowedRoles !== null && !in_array($_SESSION['role'] ?? '', $allowedRoles)) {
        header('Location: ' . $path);
        exit;
    }
}
