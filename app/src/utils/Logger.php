<?php
require_once 'core/conn.php';
require_once 'Navigation.php';
require_once 'controllers/User.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Logger
{
  private $conn;
  private $userController;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->userController = new UserController($conn);
  }

  public function action($userId, $action, $targetTable, $targetId = null, $message = '', $ipAddress = null)
  {
    if ($ipAddress && $ipAddress == '::1') {
      $ipAddress = '127.0.0.1';
    }
    try {

      $userActionInfo = $this->userController->getInfo($userId, 'id', ['name']);

      $sql = "INSERT INTO logs (user_id, user_name, action, target_table, target_id, message, ip_address, timestamp) 
                    VALUES (:user_id, :user_name, :action, :target_table, :target_id, :message, :ip_address, :timestamp)";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':user_id' => $userId,
        ':user_name' => $userActionInfo['name'],
        ':action' => $action,
        ':target_table' => $targetTable,
        ':target_id' => $targetId,
        ':message' => $message,
        ':ip_address' => $ipAddress,
        ':timestamp' => date('d-m-Y H:i:s')
      ]);
    } catch (PDOException $e) {
      error_log("Erro ao registrar log: " . $e->getMessage());
      Navigation::alert("Não foi possível registrar o log.");
    }
  }

  public function getInfo($id)
  {
    try {
      $sql = "SELECT * FROM logs WHERE id = :id AND active = 1";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result !== false ? $result : null;
    } catch (PDOException $e) {
      error_log("Erro ao buscar log específico: " . $e->getMessage());
      Navigation::alert("Não foi possível buscar o log solicitado.");
    }
  }

  public function getLogs($filters = [])
  {
    try {
      $sql = "SELECT * FROM logs WHERE 1=1 AND active = 1";
      $params = [];

      $filterMappings = [
        'action' => 'action',
        'user_id' => 'user_id',
        'target_id' => 'target_id',
        'target_table' => 'target_table',
        'date_from' => 'timestamp >=',
        'date_to' => 'timestamp <='
      ];

      foreach ($filterMappings as $filterKey => $sqlCondition) {
        if (!empty($filters[$filterKey])) {
          $sql .= " AND $sqlCondition = :$filterKey";
          $params[":$filterKey"] = $filters[$filterKey];
        }
      }

      $sql .= " ORDER BY id DESC";

      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Erro ao buscar logs: " . $e->getMessage());
      Navigation::alert("Não foi possível buscar os logs.");
    }
  }

  public function exportLog($id, $format = 'json')
  {
    if (empty($id) || !is_numeric($id) || $id <= 0) {
      $this->outputError("ID inválido.", 400);
      return;
    }

    $data = $this->getInfo($id);

    if (!$data) {
      $this->outputError("Log não encontrado para o ID: $id", 404);
      return;
    }

    switch (strtolower($format)) {
      case 'json':
        $this->exportAsJson($data);
        break;

      case 'excel':
        $this->exportAsExcel($data);
        break;

      default:
        Navigation::alert("Formato não suportado: $format");
        break;
    }
  }

  private function exportAsJson($data)
  {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="EPAracati_log_' . $data['id'] . '.json"');

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
  }

  private function exportAsExcel($data)
  {
    $formatHeader = [
      'id' => 'ID',
      'user_id' => 'ID do Responsável',
      'user_name' => 'Nome do Responsável',
      'action' => 'Ação',
      'target_table' => 'Tabela Alvo',
      'target_id' => 'ID Alvo',
      'message' => 'Mensagem',
      'ip_address' => 'Endereço IP',
      'timestamp' => 'Data e Hora'
    ];

    $excludeFields = ['active'];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Detalhes do Log');

    $row = 1;
    foreach ($data as $key => $value) {

      if (in_array($key, $excludeFields)) {
        continue;
      }

      $header = isset($formatHeader[$key]) ? $formatHeader[$key] : ucfirst(str_replace('_', ' ', $key));

      $sheet->setCellValue('A' . $row, $header);
      $sheet->setCellValue('B' . $row, $value);

      $sheet->getStyle('A' . $row)->getFont()->setBold(true);

      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="EPAracati_registro_' . $data['id'] . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
  }

  private function outputError($message, $code = 500)
  {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode(['error' => $message]);
    exit;
  }

  public function deactivate($id)
  {
    $sql = "UPDATE logs SET active = 0 WHERE id = :log_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':log_id' => $id]);
  }

  public function deleteOldLogs($days)
  {
    try {
      $sql = "DELETE FROM logs WHERE timestamp < NOW() - INTERVAL :days DAY";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([':days' => $days]);
    } catch (PDOException $e) {
      error_log("Erro ao deletar logs antigos: " . $e->getMessage());
      Navigation::alert("Não foi possível deletar logs antigos.");
    }
  }
}
