<?php
require_once "../../../bootstrap.php";

header('Content-Type: application/json');

try {
    $userModel->updateTheme($_SESSION['id'], $currentUser['preferences']['theme']);

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
