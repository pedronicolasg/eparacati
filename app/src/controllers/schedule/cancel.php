<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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
  $id = isset($_GET["id"]) ? (int)$_GET["id"] : null;

  if (!$id) {
    if (!isset($_SESSION['alert'])) {
      $_SESSION['alert'] = [];
    }
    $_SESSION['alert'][] = [
      'titulo' => 'Dados Incompletos',
      'mensagem' => 'ID é obrigatório.',
      'tipo' => 'error'
    ];
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
  }

  $booking = $scheduleModel->getInfo($id);

  if ($currentUser['role'] == 'gestao') {
    $scheduleModel->cancel(['id' => $id]);
    
    $equipmentInfo = $equipmentModel->getInfo($booking['equipment_id']);
    $equipmentName = isset($equipmentInfo['name']) ? $equipmentInfo['name'] : 'Equipamento';
    
    if ($booking['user_id'] != $currentUser['id']) {
      $userInfo = $userModel->getInfo($booking['user_id'], 'id', ['name']);
      $userName = isset($userInfo['name']) ? $userInfo['name'] : 'Usuário';
      $message = "Agendamento do equipamento '$equipmentName' de $userName para {$booking['date']} no horário {$booking['schedule']} cancelado administrativamente";
      
      $logger->action(
        $currentUser['id'],
        'delete',
        'bookings',
        $id,
        $message,
        Security::getIp()
      );
      
      $_SESSION['alert'][] = [
        'titulo' => 'Cancelamento Realizado',
        'mensagem' => 'Agendamento de outro usuário cancelado com sucesso!',
        'tipo' => 'success'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);
    } else {
      $message = "Agendamento do equipamento '$equipmentName' para {$booking['date']} no horário {$booking['schedule']} cancelado";
      
      $logger->action(
        $currentUser['id'],
        'delete',
        'bookings',
        $id,
        $message,
        Security::getIp()
      );
      
      $_SESSION['alert'][] = [
        'titulo' => 'Cancelamento Realizado',
        'mensagem' => 'Agendamento cancelado com sucesso!',
        'tipo' => 'success'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);
    }
  } else {
    if (!$booking || $booking['user_id'] != $currentUser['id']) {
      if (!isset($_SESSION['alert'])) {
        $_SESSION['alert'] = [];
      }
      $_SESSION['alert'][] = [
        'titulo' => 'Permissão Negada',
        'mensagem' => 'Você não possui permissão para cancelar este agendamento.',
        'tipo' => 'error'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);
      exit;
    } else {
      $scheduleModel->cancel(['id' => $id]);
      
      $equipmentInfo = $equipmentModel->getInfo($booking['equipment_id']);
      $equipmentName = isset($equipmentInfo['name']) ? $equipmentInfo['name'] : 'Equipamento';
      $message = "Agendamento do equipamento '$equipmentName' para {$booking['date']} no horário {$booking['schedule']} cancelado";
      
      $logger->action(
        $currentUser['id'],
        'delete',
        'bookings',
        $id,
        $message,
        Security::getIp()
      );
      
      $_SESSION['alert'][] = [
        'titulo' => 'Cancelamento Realizado',
        'mensagem' => 'Agendamento cancelado com sucesso!',
        'tipo' => 'success'
      ];
      Navigation::redirect($_SERVER['HTTP_REFERER']);}
  }
} catch (Exception $e) {
  if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = [];
  }
  $_SESSION['alert'][] = [
    'titulo' => 'Erro ao Cancelar',
    'mensagem' => $e->getMessage(),
    'tipo' => 'error'
  ];
  Navigation::redirect($_SERVER['HTTP_REFERER']);
  exit;
}
