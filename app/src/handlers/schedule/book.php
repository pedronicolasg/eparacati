<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $equipmentId = isset($_POST["equipment_id"]) ? (string)$_POST["equipment_id"] : null;
  $selectedDate = isset($_POST["selected_date"]) ? (string)$_POST["selected_date"] : null;
  $timeSlots = isset($_POST["time_slots"]) ? (array)$_POST["time_slots"] : [];

  $classId = isset($_POST["class_id"]) && !empty($_POST["class_id"]) ? (string)$_POST["class_id"] : null;
  $notes = isset($_POST["notes"]) ? Security::sanitizeInput((string)$_POST["notes"]) : "";

  $errors = [];

  if (!$equipmentId) {
    $errors[] = "Equipamento é obrigatório.";
  }

  if (!$selectedDate) {
    $errors[] = "Data é obrigatória.";
  }

  if (empty($timeSlots)) {
    $errors[] = "Pelo menos um horário deve ser selecionado.";
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
        Navigation::alert($message, $_SERVER['HTTP_REFERER']);
      } else {
        Navigation::alert('Não foi possível realizar o agendamento. Verifique disponibilidade.', $_SERVER['HTTP_REFERER']);
      }
    } catch (Exception $e) {
      Navigation::alert('Erro ao agendar equipamento: ' . $e->getMessage(), $_SERVER['HTTP_REFERER']);
    }
  } else {
    Navigation::alert(implode('<br>', $errors), $_SERVER['HTTP_REFERER']);
  }

  Navigation::redirect($_SERVER['HTTP_REFERER']);
} else {
  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
