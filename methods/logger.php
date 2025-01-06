<?php
require_once 'conn.php';

class Logger
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function action($userId, $userName, $action, $targetTable, $targetId = null, $message = '', $ipAddress = null)
  {
    try {
      $sql = "INSERT INTO logs (user_id, user_name, action, target_table, target_id, message, ip_address) 
                    VALUES (:user_id, :user_name, :action, :target_table, :target_id, :message, :ip_address)";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([
        ':user_id' => $userId,
        ':user_name' => $userName,
        ':action' => $action,
        ':target_table' => $targetTable,
        ':target_id' => $targetId,
        ':message' => $message,
        ':ip_address' => $ipAddress
      ]);
    } catch (PDOException $e) {
      error_log("Erro ao registrar log: " . $e->getMessage());
      throw new Exception("Não foi possível registrar o log.");
    }
  }

  public function getLogs($filters = [])
  {
    try {
      $sql = "SELECT * FROM logs WHERE 1=1";
      $params = [];

      if (!empty($filters['action'])) {
        $sql .= " AND action = :action";
        $params[':action'] = $filters['action'];
      }

      if (!empty($filters['user_id'])) {
        $sql .= " AND user_id = :user_id";
        $params[':user_id'] = $filters['user_id'];
      }

      if (!empty($filters['target_table'])) {
        $sql .= " AND target_table = :target_table";
        $params[':target_table'] = $filters['target_table'];
      }

      if (!empty($filters['date_from'])) {
        $sql .= " AND timestamp >= :date_from";
        $params[':date_from'] = $filters['date_from'];
      }

      if (!empty($filters['date_to'])) {
        $sql .= " AND timestamp <= :date_to";
        $params[':date_to'] = $filters['date_to'];
      }

      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      error_log("Erro ao buscar logs: " . $e->getMessage());
      throw new Exception("Não foi possível buscar os logs.");
    }
  }

  public function deleteOldLogs($days)
  {
    try {
      $sql = "DELETE FROM logs WHERE timestamp < NOW() - INTERVAL :days DAY";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute([':days' => $days]);
    } catch (PDOException $e) {
      error_log("Erro ao deletar logs antigos: " . $e->getMessage());
      throw new Exception("Não foi possível deletar logs antigos.");
    }
  }
}
