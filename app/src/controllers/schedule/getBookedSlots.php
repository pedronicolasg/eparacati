<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once "../../bootstrap.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
      'titulo' => 'Método Inválido',
      'mensagem' => 'Método inválido',
      'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}

$equipmentId = isset($_POST['equipment_id']) ? (string)$_POST['equipment_id'] : null;
$date = isset($_POST['date']) ? (string)$_POST['date'] : null;

if (!$equipmentId || !ctype_digit($equipmentId) || !$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
  http_response_code(400);
  echo json_encode([]);
  exit;
}

try {
  $bookedTimeSlots = $scheduleModel->getBookedTimeSlots($equipmentId, $date);
  echo json_encode($bookedTimeSlots);
} catch (Exception $e) {
  error_log('Error in get_booked_slots.php: ' . $e->getMessage());
  http_response_code(500);
  echo json_encode([]);
}

exit;
