<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
require_once "../../bootstrap.php";

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

try {
  $timeSlots = isset($_POST["time_slots"]) ? (array)$_POST["time_slots"] : [];
  $equipmentId = isset($_POST["equipment_id"]) ? (string)$_POST["equipment_id"] : null;
  $selectedDate = isset($_POST["selected_date"]) ? (string)$_POST["selected_date"] : null;
  $notes = isset($_POST["notes"]) ? Security::sanitizeInput((string)$_POST["notes"]) : null;
  $classId = isset($_POST["class_id"]) && !empty($_POST["class_id"]) ? (string)$_POST["class_id"] : null;

  $errors = [];

  $requiredFields = [
    'equipmentId' => 'Equipamento é obrigatório.',
    'selectedDate' => 'Data é obrigatória.',
    'timeSlots' => 'Pelo menos um horário deve ser selecionado.',
    'notes' => 'Observações são obrigatórias.',
    'classId' => 'Turma é obrigatória.'
  ];

  foreach ($requiredFields as $field => $errorMessage) {
    if (empty($$field) || ($field === 'timeSlots' && empty($timeSlots))) {
      $errors[] = $errorMessage;
    }
  }

  $currentDate = new DateTime();
  $bookingDate = new DateTime($selectedDate);
  $bookingDate->setTime(0, 0, 0);
  $currentDate->setTime(0, 0, 0);

  if ($bookingDate < $currentDate) {
    $errors[] = "Não é possível agendar para datas passadas.";
  }

  foreach ($timeSlots as $slot) {
    if (!in_array($slot, ['1', '2', '3', '4', '5', '6', '7', '8', '9'])) {
      $errors[] = "Horário inválido selecionado.";
      break;
    }
  }

  if (empty($errors)) {
    try {
      $successCount = 0;
      $equipment = $equipmentController->getInfo($equipmentId);
      $equipmentName = isset($equipment['name']) ? $equipment['name'] : 'Equipamento';

      foreach ($timeSlots as $schedule) {
        $result = $scheduleController->book(
          $equipmentId,
          $selectedDate,
          $schedule,
          $currentUser['id'],
          $classId,
          $notes
        );

        if ($result) {
          $successCount++;

          $logger->action(
            $currentUser['id'],
            'book',
            'bookings',
            $result,
            "Agendamento do equipamento '$equipmentName' para " . date('d-m-Y', strtotime($selectedDate)) . " no horário $schedule",
            Security::getIp()
          );
        }
      }

      if ($successCount > 0) {
        $message = $successCount == 1
          ? "Equipamento agendado com sucesso para 1 horário!"
          : "Equipamento agendado com sucesso para $successCount horários!";
        $_SESSION['alert'][] = [
          'titulo' => 'Agendamento Realizado',
          'mensagem' => $message,
          'tipo' => 'success'
        ];
        Navigation::redirect('../../../agendae/index.php', true);
      } else {
        $_SESSION['alert'][] = [
          'titulo' => 'Falha no Agendamento',
          'mensagem' => 'Não foi possível realizar o agendamento. Verifique disponibilidade.',
          'tipo' => 'error'
        ];
        Navigation::redirect($_SERVER['HTTP_REFERER']);
      }
    } catch (Exception $e) {
      $_SESSION['alert'][] = [
        'titulo' => 'Erro no Agendamento',
        'mensagem' => 'Erro ao agendar equipamento: ' . $e->getMessage(),
        'tipo' => 'error'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);
    }
  } else {
    $_SESSION['alert'][] = [
      'titulo' => 'Erro de Validação',
      'mensagem' => implode('<br>', $errors),
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
  }
} catch (Exception $e) {
  $_SESSION['alert'][] = [
    'titulo' => 'Erro Inesperado',
    'mensagem' => $e->getMessage(),
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
