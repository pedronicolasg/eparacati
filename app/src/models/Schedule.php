<?php
require_once 'core/conn.php';
require_once 'models/Equipment.php';
require_once 'models/Class.php';
require_once 'utils/Navigation.php';

class ScheduleModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  private function getEquipmentModel()
  {
    return new EquipmentModel($this->conn);
  }

  private function getUserModel()
  {
    return new UserModel($this->conn);
  }

  private function getClassModel()
  {
    return new ClassModel($this->conn);
  }

  public function count($filters = [], $period = null)
  {
    $sql = 'SELECT COUNT(*) FROM bookings';
    $params = [];
    $conditions = [];

    if ($period) {
      $now = new DateTime();
      switch ($period) {
        case 'today':
          $conditions[] = "date = :date";
          $params[':date'] = $now->format('d-m-Y');
          break;
        case 'week':
          $weekStart = (clone $now)->modify('monday this week');
          $weekEnd = (clone $now)->modify('sunday this week');
          $conditions[] = "STR_TO_DATE(date, '%d-%m-%Y') BETWEEN STR_TO_DATE(:week_start, '%d-%m-%Y') AND STR_TO_DATE(:week_end, '%d-%m-%Y')";
          $params[':week_start'] = $weekStart->format('d-m-Y');
          $params[':week_end'] = $weekEnd->format('d-m-Y');
          break;
        case 'month':
          $monthStart = (clone $now)->modify('first day of this month');
          $monthEnd = (clone $now)->modify('last day of this month');
          $conditions[] = "STR_TO_DATE(date, '%d-%m-%Y') BETWEEN STR_TO_DATE(:month_start, '%d-%m-%Y') AND STR_TO_DATE(:month_end, '%d-%m-%Y')";
          $params[':month_start'] = $monthStart->format('d-m-Y');
          $params[':month_end'] = $monthEnd->format('d-m-Y');
          break;
      }
    }

    if (!empty($filters)) {
      foreach ($filters as $key => $value) {
        $conditions[] = "$key = :$key";
        $params[":$key"] = $value;
      }
    }

    if (!empty($conditions)) {
      $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
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
            "",
            "error",
            $_SERVER['HTTP_REFERER']
          );
        }
      }
    }

    $fields = implode(", ", $fields);
    $sql = "SELECT $fields FROM bookings";
    $params = [];
    $now = new DateTime();
    $currentDate = $now->format('d-m-Y');

    $limit = null;
    if (!empty($filters)) {
      $filterClauses = [];
      foreach ($filters as $key => $value) {
        if ($key === 'limit') {
          $limit = (int)$value;
          continue;
        }
        if ($key === 'offset') {
          continue;
        }
        $filterClauses[] = "$key = :$key";
        $params[":$key"] = $value;
      }
      if (!empty($filterClauses)) {
        $sql .= " WHERE " . implode(" AND ", $filterClauses);
      }
    }

    if (isset($filters['date'])) {
      $sql .= " ORDER BY STR_TO_DATE(date, '%d-%m-%Y') DESC, schedule ASC";
    }
    if ($limit !== null) {
      $sql .= " LIMIT " . $limit;
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $models = [
      'equipment_id' => 'getEquipmentModel',
      'user_id' => 'getUserModel',
      'class_id' => 'getClassModel'
    ];

    foreach ($bookings as &$booking) {
      foreach ($models as $key => $method) {
        if (isset($booking[$key])) {
          $controller = $this->$method();
          $info = $controller->getInfo($booking[$key]);
          $booking[str_replace('_id', '_info', $key)] = $info;
        }
      }
    }

    return $bookings;
  }

  public static function getTimeSlots()
  {
    return [
      ['id' => '1', 'period' => 'matutino', 'name' => '1ª Aula', 'start' => '07:30', 'end' => '08:20'],
      ['id' => '2', 'period' => 'matutino', 'name' => '2ª Aula', 'start' => '08:20', 'end' => '09:10'],
      ['id' => '3', 'period' => 'matutino', 'name' => '3ª Aula', 'start' => '09:30', 'end' => '10:20'],
      ['id' => '4', 'period' => 'matutino', 'name' => '4ª Aula', 'start' => '10:20', 'end' => '11:10'],
      ['id' => '5', 'period' => 'matutino', 'name' => '5ª Aula', 'start' => '11:10', 'end' => '12:00'],
      ['id' => '6', 'period' => 'vespertino', 'name' => '6ª Aula', 'start' => '13:20', 'end' => '14:20'],
      ['id' => '7', 'period' => 'vespertino', 'name' => '7ª Aula', 'start' => '14:20', 'end' => '15:10'],
      ['id' => '8', 'period' => 'vespertino', 'name' => '8ª Aula', 'start' => '15:30', 'end' => '16:10'],
      ['id' => '9', 'period' => 'vespertino', 'name' => '9ª Aula', 'start' => '16:10', 'end' => '17:00']
    ];
  }

  public function getBookedTimeSlots($equipmentId, $date)
  {
    $query = "SELECT schedule FROM bookings WHERE equipment_id = :equipment_id AND STR_TO_DATE(date, '%d-%m-%Y') = STR_TO_DATE(:date, '%Y-%m-%d')";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':equipment_id' => $equipmentId,
      ':date' => $date
    ]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }

  public function getInfo($id)
  {
    $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($booking) {
      if (isset($booking['equipment_id'])) {
        $equipmentModel = $this->getEquipmentModel();
        $equipmentInfo = $equipmentModel->getInfo($booking['equipment_id']);
        $booking['equipment_info'] = $equipmentInfo;
      }

      if (isset($booking['user_id'])) {
        $userModel = $this->getUserModel();
        $user = $userModel->getInfo($booking['user_id']);
        $booking['user_info'] = $user;
      }

      if (isset($booking['class_id'])) {
        $classModel = $this->getClassModel();
        $classInfo = $classModel->getInfo($booking['class_id']);
        $booking['class_info'] = $classInfo;
      }
    }

    return $booking;
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
        Navigation::alert(
          "Equipamento não encontrado",
          "",
          "error",
          $_SERVER['HTTP_REFERER']
        );
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
      Navigation::alert(
        "Erro ao processar agendamento",
        $e->getMessage(),
        "error",
        $_SERVER['HTTP_REFERER']
      );
    }
  }

  public function cancel($filters = [])
  {
    try {
      if (empty($filters)) {
        Navigation::alert(
          "Filtros inválidos",
          "Os filtros não podem estar vazios para cancelar um agendamento.",
          "error",
          $_SERVER['HTTP_REFERER']
        );
        return false;
      }

      $sql = "DELETE FROM bookings WHERE 1=1";
      $params = [];

      foreach ($filters as $key => $value) {
        $sql .= " AND $key = :$key";
        $params[$key] = $value;
      }

      $stmt = $this->conn->prepare($sql);
      $stmt->execute($params);
      return $stmt->rowCount() > 0;
    } catch (Exception $e) {
      Navigation::alert(
        "Erro ao cancelar agendamento",
        $e->getMessage(),
        "error",
        $_SERVER['HTTP_REFERER']
      );
      return false;
    }
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
      Navigation::alert(
        "Erro ao limpar agendamentos passados",
        $e->getMessage(),
        "error"
      );
      return false;
    }
  }

  public function exportToPdf($scheduleId)
  {
    try {
      $schedule = $this->getInfo($scheduleId);

      if (!$schedule) {
        return false;
      }

      $defaultConfig = (
        new \Mpdf\Config\ConfigVariables()
      )->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (
        new \Mpdf\Config\FontVariables()
      )->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 16,
        'margin_bottom' => 16,
        'margin_header' => 9,
        'margin_footer' => 9,
        'fontDir' => array_merge($fontDirs, [
          dirname(dirname(dirname(__DIR__))) . '/public/fonts',
        ]),
        'fontdata' => $fontData + [
          'exo' => [
            'R' => 'Exo-Regular.ttf',
            'B' => 'Exo-Bold.ttf',
          ],
        ],
        'default_font' => 'exo'
      ]);


      $equipment = $schedule['equipment_info'];
      $user = $schedule['user_info'];
      $class = $schedule['class_info'] ?? null;

      $mpdf->SetTitle('Agendamento #' . $schedule['id']);
      $mpdf->SetAuthor($user['name'] ?? 'Desconhecido');
      $mpdf->SetCreator('Agendaê - Sistema de Agendamento');

      $timeSlots = self::getTimeSlots();
      $selectedTimeSlot = array_filter($timeSlots, function ($slot) use ($schedule) {
        return $slot['id'] === $schedule['schedule'];
      });
      $selectedTimeSlot = reset($selectedTimeSlot);

      $formattedDate = str_replace('-', '/', $schedule['date']);

      $templatePath = dirname(dirname(dirname(__DIR__))) . '/public/templates/pdf/schedule_template.php';


      ob_start();
      include $templatePath;
      $html = ob_get_clean();

      $mpdf->WriteHTML($html);

      return $mpdf;
    } catch (Exception $e) {
      Navigation::alert(
        "Erro ao gerar PDF",
        $e->getMessage(),
        "error",
        $_SERVER['HTTP_REFERER']
      );
      return false;
    }
  }
}
