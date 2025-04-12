<?php
require_once "../../../bootstrap.php";

header('Content-Type: application/json');

try {
    $userController->updateTheme($_SESSION['id']);
    
    echo json_encode([
        'success' => true,
        'message' => 'Tema atualizado com sucesso'
    ]);
    exit();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar tema: ' . $e->getMessage()
    ]);
    exit();
}