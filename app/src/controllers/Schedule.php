<?php
require_once 'core/conn.php';
require_once 'controllers/Equipment.php';
require_once 'controllers/Class.php';
require_once 'utils/Navigation.php';

class ScheduleController
{

  private $conn;
  private $equipmentController;
  private $userController;
  private $classController;
  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->equipmentController = new EquipmentController($conn);
    $this->userController = new UserController($conn);
    $this->classController = new ClassController($conn);
  }

  public function count($filters = [])
  {
    $sql = 'SELECT COUNT(*) FROM bookings';
    $params = [];

    if (!empty($filters)) {
      $conditions = [];
      foreach ($filters as $key => $value) {
        $conditions[] = "$key = :$key";
        $params[":$key"] = $value;
      }
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
  }

  public static function getTimeSlots()
  {
    return [
      ['id' => '1', 'period' => 'matutino', 'name' => '1ª Aula', 'start' => '07:30', 'end' => '08:20'],
      ['id' => '2', 'period' => 'matutino', 'name' => '2ª Aula', 'start' => '08:20', 'end' => '09:10'],
      ['id' => '3', 'period' => 'matutino', 'name' => '3ª Aula', 'start' => '09:30', 'end' => '10:00'],
      ['id' => '4', 'period' => 'matutino', 'name' => '4ª Aula', 'start' => '10:20', 'end' => '11:10'],
      ['id' => '5', 'period' => 'matutino', 'name' => '5ª Aula', 'start' => '11:10', 'end' => '12:00'],

      ['id' => '6', 'period' => 'vespertino', 'name' => '6ª Aula', 'start' => '13:20', 'end' => '14:20'],
      ['id' => '7', 'period' => 'vespertino', 'name' => '7ª Aula', 'start' => '14:10', 'end' => '15:10'],
      ['id' => '8', 'period' => 'vespertino', 'name' => '8ª Aula', 'start' => '15:30', 'end' => '16:00'],
      ['id' => '9', 'period' => 'vespertino', 'name' => '9ª Aula', 'start' => '16:10', 'end' => '17:00']
    ];
  }

  public function getInfo($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function get($filters = [], $fields = [])
  {
    $defaultFields = ['id', 'date', 'schedule', 'equipment_id', 'user_id', 'class_id', 'note'];

    if (empty($fields)) {
      $fields = $defaultFields;
    } else {
      foreach ($fields as $field) {
        if (!in_array($field, $defaultFields)) {
          Navigation::alert(
            "Campo inválido: $field",
            $_SERVER['HTTP_REFERER']
          );
        }
      }
    }

    $fields = implode(", ", $fields);
    $sql = "SELECT $fields FROM bookings";
    $params = [];

    if (!empty($filters)) {
      $filterClauses = [];
      foreach ($filters as $key => $value) {
        if ($key === 'limit' || $key === 'offset') {
          continue;
        }
        $filterClauses[] = "$key = :$key";
        $params[":$key"] = $value;
      }

      if (isset($filters['limit']) && isset($filters['offset'])) {
        $sql .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = (int)$filters['limit'];
        $params[':offset'] = (int)$filters['offset'];
      }

      $sql .= " WHERE " . implode(" AND ", $filterClauses);
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($bookings as &$booking) {
      if (isset($booking['equipment_id'])) {
        $equipmentInfo = $this->equipmentController->getInfo($booking['equipment_id']);
        $booking['equipment_info'] = $equipmentInfo;
      }

      if (isset($booking['user_id'])) {
        $user = $this->userController->getInfo($booking['user_id']);
        $booking['user_info'] = $user;
      }

      if (isset($booking['class_id'])) {
        $classInfo = $this->classController->getInfo($booking['class_id']);
        $booking['class_info'] = $classInfo;
      }
    }

    return $bookings;
  }

  public function cleanPastBookings()
  {
    try {
      $now = new DateTime();
      $currentDate = $now->format('d-m-Y');
      $currentTime = $now->format('H:i');

      $timeSlots = self::getTimeSlots();

      $lastMorningSlot = null;
      $lastAfternoonSlot = null;

      foreach ($timeSlots as $slot) {
        if ($slot['period'] === 'matutino') {
          $lastMorningSlot = $slot;
        } elseif ($slot['period'] === 'vespertino') {
          $lastAfternoonSlot = $slot;
        }
      }

      $stmt = $this->conn->prepare(
        "DELETE FROM bookings 
               WHERE STR_TO_DATE(date, '%d-%m-%Y') < STR_TO_DATE(:currentDate, '%d-%m-%Y')"
      );
      $stmt->execute([':currentDate' => $currentDate]);
      $deletedCount = $stmt->rowCount();

      $timeConditions = [];
      $params = [':currentDate' => $currentDate];

      if ($lastMorningSlot && $currentTime > $lastMorningSlot['end']) {
        $timeConditions[] = "(schedule BETWEEN 1 AND 5)";
      }

      if ($lastAfternoonSlot && $currentTime > $lastAfternoonSlot['end']) {
        $timeConditions[] = "(schedule BETWEEN 6 AND 9)";
      }

      if (!empty($timeConditions)) {
        $sql = "DELETE FROM bookings 
                      WHERE date = :currentDate 
                      AND (" . implode(" OR ", $timeConditions) . ")";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $deletedCount += $stmt->rowCount();
      }

      return $deletedCount;
    } catch (Exception $e) {
      Navigation::alert("Erro ao limpar agendamentos passados: " . $e->getMessage());
      return false;
    }
  }

  public function book($equipmentId, $date, $schedule, $userId, $classId = null, $note = '')
  {
    try {
      $dateObj = new DateTime($date);
      $formattedDate = $dateObj->format('d-m-Y');

      $stmt = $this->conn->prepare(
        "SELECT id FROM bookings 
           WHERE equipment_id = :equipment_id 
           AND date = :date 
           AND schedule = :schedule"
      );

      $stmt->execute([
        'equipment_id' => $equipmentId,
        'date' => $formattedDate,
        'schedule' => $schedule
      ]);

      $existingBooking = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($existingBooking) {
        return false;
      }

      $stmt = $this->conn->prepare("SELECT id FROM equipments WHERE id = :id");
      $stmt->execute(['id' => $equipmentId]);
      $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$equipment) {
        Navigation::alert("Equipamento não encontrado", $_SERVER['HTTP_REFERER']);
      }

      $sql = "INSERT INTO bookings (equipment_id, date, schedule, user_id, note";

      if ($classId !== null) {
        $sql .= ", class_id";
      }

      $sql .= ") VALUES (:equipment_id, :date, :schedule, :user_id, :note";

      if ($classId !== null) {
        $sql .= ", :class_id";
      }

      $sql .= ")";

      $stmt = $this->conn->prepare($sql);

      $params = [
        'equipment_id' => $equipmentId,
        'date' => $formattedDate,
        'schedule' => $schedule,
        'user_id' => $userId,
        'note' => $note
      ];

      if ($classId !== null) {
        $params['class_id'] = $classId;
      }

      $result = $stmt->execute($params);

      if ($result) {
        return $this->conn->lastInsertId();
      }

      return false;
    } catch (Exception $e) {
      Navigation::alert("Erro ao processar agendamento: " . $e->getMessage(), $_SERVER['HTTP_REFERER']);
    }
  }

  public function cancel($id)
  {
    try {
      $stmt = $this->conn->prepare("DELETE FROM bookings WHERE id = :id");
      $stmt->execute(['id' => $id]);
      return $stmt->rowCount() > 0;
    } catch (Exception $e) {
      Navigation::alert("Erro ao cancelar agendamento: " . $e->getMessage(), $_SERVER['HTTP_REFERER']);
    }
  }
}
