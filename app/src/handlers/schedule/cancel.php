<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
require_once "../../bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $id = isset($_GET["id"]) ? (int)$_GET["id"] : null;
  
  if (!$id) {
    Navigation::alert("ID é obrigatório.", $_SERVER['HTTP_REFERER']);
  }

  $booking = $scheduleController->getInfo($id);

  if ($currentUser['role'] == 'gestao'){
    $scheduleController->cancel($id);
    Navigation::alert('Agendamento cancelado com sucesso!', $_SERVER['HTTP_REFERER']);
  } else {
    if(!$booking || $booking['user_id'] != $currentUser['id']){
      Navigation::alert('Você não possui permissão para cancelar este agendamento.', $_SERVER['HTTP_REFERER']);
    } else {
      $scheduleController->cancel($id);
      Navigation::alert('Agendamento cancelado com sucesso!', $_SERVER['HTTP_REFERER']);
    }
  }

}
