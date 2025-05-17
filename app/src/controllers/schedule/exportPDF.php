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

$scheduleId = $_GET['id'] ?? null;

if (!$scheduleId) {
    Navigation::redirect($_SERVER['HTTP_REFERER']);
    exit;
}

$pdf = $scheduleModel->exportToPdf($scheduleId);

if (!$pdf) {
    Navigation::alert(
        "Erro na exportação",
        'Não foi possível gerar o PDF do agendamento',
        "error",
        '../../agendae/agendamento.php?id=' . $scheduleId
    );
    exit;
}

$filename = 'agendamento_' . $scheduleId . '.pdf';

$pdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);
exit;
