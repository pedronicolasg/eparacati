<?php
$allowUnauthenticatedAccess = true;
header('Content-Type: application/json');
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $key = Security::sanitizeInput(trim($_POST['activation_key'] ?? ''));

  if (empty($key)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, insira uma chave de ativação.']);
    exit;
  }

  try {
    $stmt = $conn->prepare("SELECT * FROM setupKeys WHERE `key` = :key AND active = 1");
    $stmt->execute(['key' => $key]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      echo json_encode(['success' => true, 'message' => 'Chave válida.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Chave inválida ou já utilizada.']);
    }
  } catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no servidor. Tente novamente mais tarde.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
