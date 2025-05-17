<?php
require_once 'core/conn.php';

require_once 'models/Schedule.php';

require_once 'utils/Security.php';
require_once 'utils/Navigation.php';
require_once 'utils/FileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class EquipmentModel
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  private function getSecurity()
  {
    return new Security($this->conn);
  }

  private function getFileUploader()
  {
    return new FileUploader();
  }

  private function getScheduleModel()
  {
    return new ScheduleModel($this->conn);
  }

  public function count($filters = [])
  {
    $sql = 'SELECT COUNT(*) FROM equipments';
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

  public function get($fields = [], $filters = [])
  {
    $defaultFields = ['id', 'name', 'status', 'type', 'description', 'image', 'created_at'];

    if (empty($fields)) {
      $fields = $defaultFields;
    } else {
      foreach ($fields as $field) {
        if (!in_array($field, $defaultFields)) {
          Navigation::alert(
            "Campo inválido",
            "O campo: '$field' é invalido",
            "error",
            $_SERVER['HTTP_REFERER']
          );
        }
      }
    }

    $fields = implode(", ", $fields);
    $sql = "SELECT $fields FROM equipments";
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

    if (isset($filters['limit']) && isset($filters['offset'])) {
      $sql .= " LIMIT :limit OFFSET :offset";
      $params[':limit'] = (int)$filters['limit'];
      $params[':offset'] = (int)$filters['offset'];
    }

    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getInfo($id, $fields = [])
  {
    $defaultFields = ['id', 'name', 'status', 'type', 'description', 'image', 'created_at', 'updated_at'];

    if (empty($fields)) {
      $fields = $defaultFields;
    } else {
      foreach ($fields as $field) {
        if (!in_array($field, $defaultFields)) {
          Navigation::alert(
            "Campo inválido",
            "O campo: '$field' é invalido",
            "error",
            $_SERVER['HTTP_REFERER']
          );
        }
      }
    }

    $fields = implode(", ", $fields);
    $sql = "SELECT $fields FROM equipments WHERE id =?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getTypes()
  {
    $sql = "SHOW COLUMNS FROM equipments LIKE 'type'";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && preg_match("/^enum\((.*)\)$/", $result['Type'], $matches)) {
      return str_getcsv($matches[1], ',', "'");
    }

    return [];
  }

  public function register($name, $type, $status, $description = null, $image = null, $alerts = true)
  {
    $validTypes = $this->getTypes();
    $validStatuses = ['disponivel', 'indisponivel'];

    if (empty($name) || empty($type)) {
      if ($alerts) {
        Navigation::alert(
          "Preencha todos os campos!",
          "",
          "warning",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    }

    if (!in_array($type, $validTypes)) {
      if ($alerts) {
        Navigation::alert(
          "Tipo inválido",
          "O tipo: '$type' é inválido",
          "error",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    }

    $status = empty($status) ? 'disponivel' : $status;
    if (!in_array($status, $validStatuses)) {
      if ($alerts) {
        Navigation::alert(
          "Status inválido",
          "O status: '$status' é inválido",
          "error",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    }

    $security = $this->getSecurity();
    $id = $security->generateUniqueId(8, "equipments");
    $created_at = date("d-m-Y H:i:s");
    $imageUrl = $image ? $this->addPhoto($image, $id) : null;

    try {
      $this->conn->beginTransaction();

      $stmt = $this->conn->prepare("SELECT id FROM equipments WHERE name = :name FOR UPDATE");
      $stmt->execute(['name' => $name]);
      if ($stmt->fetchColumn()) {
        $this->conn->rollBack();
        if ($alerts) {
          Navigation::alert(
            "Equipamento já existente",
            "Já existe um equipamento com esse nome!",
            "warning",
            $_SERVER['HTTP_REFERER']
          );
        }
        return false;
      }

      $stmt = $this->conn->prepare('
                INSERT INTO equipments (id, name, type, status, description, image, created_at)
                VALUES (:id, :name, :type, :status, :description, :image, :created_at)
            ');
      $stmt->execute([
        'id' => $id,
        'name' => $name,
        'type' => $type,
        'status' => $status,
        'description' => $description,
        'image' => $imageUrl,
        'created_at' => $created_at
      ]);

      $this->conn->commit();
      return $id;
    } catch (Exception $e) {
      $this->conn->rollBack();
      if ($alerts) {
        throw $e;
      }
      return false;
    }
  }

  public function bulkRegister($filePath)
  {
    try {
      $spreadsheet = IOFactory::load($filePath);
      $worksheet = $spreadsheet->getActiveSheet();
      $rows = $worksheet->toArray();
      array_shift($rows);

      $results = ['success' => 0, 'errors' => [], 'created_equipments' => []];
      $equipmentData = [];
      $chunkSize = 100;
      $validTypes = $this->getTypes();
      $validStatuses = ['disponivel', 'indisponivel'];

      $names = [];
      foreach ($rows as $index => $row) {
        if (empty($row[0]) || empty($row[1])) {
          $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
          continue;
        }

        if (!in_array($row[1], $validTypes)) {
          $results['errors'][] = "Linha " . ($index + 2) . ": Tipo inválido '$row[1]'";
          continue;
        }

        $status = empty($row[2]) ? 'disponivel' : $row[2];
        if (!in_array($status, $validStatuses)) {
          $results['errors'][] = "Linha " . ($index + 2) . ": Status inválido '$status'";
          continue;
        }

        $security = $this->getSecurity();
        $id = $security->generateUniqueId(8, 'equipments');
        $imageUrl = !empty($row[4]) ? $this->addPhoto($row[4], $id) : null;

        $names[] = $row[0];
        $equipmentData[] = [
          'id' => $id,
          'name' => $row[0],
          'type' => $row[1],
          'status' => $status,
          'description' => !empty($row[3]) ? $row[3] : null,
          'image' => $imageUrl,
          'created_at' => date("d-m-Y H:i:s")
        ];
        $results['created_equipments'][$row[0]] = $id;
      }

      if ($names) {
        $placeholders = implode(',', array_fill(0, count($names), '?'));
        $stmt = $this->conn->prepare("SELECT name FROM equipments WHERE name IN ($placeholders) FOR UPDATE");
        $stmt->execute($names);
        $existingNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if ($existingNames) {
          foreach ($equipmentData as $index => $data) {
            if (in_array($data['name'], $existingNames)) {
              $results['errors'][] = "Linha " . ($index + 2) . ": Equipamento com nome '{$data['name']}' já existe";
              unset($equipmentData[$index]);
            }
          }
          $equipmentData = array_values($equipmentData);
        }
      }

      $this->conn->beginTransaction();
      foreach (array_chunk($equipmentData, $chunkSize) as $chunk) {
        try {
          $values = [];
          $params = [];
          foreach ($chunk as $index => $data) {
            $values[] = "(:id_$index, :name_$index, :type_$index, :status_$index, :description_$index, :image_$index, :created_at_$index)";
            $params = array_merge($params, [
              "id_$index" => $data['id'],
              "name_$index" => $data['name'],
              "type_$index" => $data['type'],
              "status_$index" => $data['status'],
              "description_$index" => $data['description'],
              "image_$index" => $data['image'],
              "created_at_$index" => $data['created_at']
            ]);
          }

          $sql = 'INSERT INTO equipments (id, name, type, status, description, image, created_at)
                            VALUES ' . implode(',', $values);
          $stmt = $this->conn->prepare($sql);
          $stmt->execute($params);

          $results['success'] += count($chunk);
        } catch (Exception $e) {
          $results['errors'][] = "Erro no lote: " . $e->getMessage();
        }
      }

      $this->conn->commit();
      return $results;
    } catch (Exception $e) {
      $this->conn->rollBack();
      Navigation::alert(
        "Erro ao processar arquivo",
        $e->getMessage(),
        "error"
      );
      return $results;
    }
  }

  public function edit($id, $data)
  {
    $currentUser = $this->getInfo($id);

    $updateFields = [];
    $params = [];

    foreach ($data as $field => $value) {
      if ($field === 'image' && $value !== null) {
        $imagePath = $this->addPhoto($value, $id);
        if ($imagePath) {
          $updateFields[] = "image = :image";
          $params[":image"] = $imagePath;
        }
      } elseif ($field === 'status' && $value === 'indisponivel') {
        $scheduleModel = $this->getScheduleModel();
        $relatedSchedules = $scheduleModel->get(['equipment_id' => $id]);
        if (!empty($relatedSchedules) && !$scheduleModel->cancel(['equipment_id' => $id])) {
          Navigation::alert(
            "Erro no cancelamento",
            "Erro ao cancelar agendamentos relacionados",
            "error",
            $_SERVER['HTTP_REFERER']
          );
        }
        $updateFields[] = "status = :status";
        $params[":status"] = 'indisponivel';
      } elseif ($value !== null && $value !== $currentUser[$field]) {
        $updateFields[] = "$field = :$field";
        $params[":$field"] = $value;
      }
    }

    if (empty($updateFields)) {
      return true;
    }

    $updateFields[] = "updated_at = :updated_at";
    $params[":updated_at"] = date("d-m-Y H:i:s");
    $params[":id"] = $id;

    $sql = "UPDATE equipments SET " . implode(", ", $updateFields) . " WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
  }

  public function delete($id)
  {
    try {
      $this->deleteImage($id);

      $scheduleModel = $this->getScheduleModel();
      $relatedSchedules = $scheduleModel->get(['equipment_id' => $id]);

      if (!empty($relatedSchedules) && !$scheduleModel->cancel(['equipment_id' => $id])) {
        Navigation::alert(
          "Erro no cancelamento",
          "Erro ao cancelar agendamentos relacionados.",
          "error",
          $_SERVER['HTTP_REFERER']
        );
      }

      $sql = "DELETE FROM equipments WHERE id = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) {
        Navigation::alert(
          "Equipamento não encontrado",
          "Nenhum equipamento encontrado com o ID fornecido.",
          "error",
          $_SERVER['HTTP_REFERER']
        );
      }
    } catch (Exception $e) {
      Navigation::alert(
        "Erro ao deletar equipamento",
        $e->getMessage(),
        "error",
        $_SERVER['HTTP_REFERER']
      );
    }
  }

  private function addPhoto($imageFile, $equipmentId)
  {
    $uploadPath = '../../../../public/images/equipment_photos/';

    $fileUploader = $this->getFileUploader();
    $pfpPath = $fileUploader->uploadImage(
      $imageFile,
      $uploadPath,
      900,
      600,
      95,
      $equipmentId
    );

    if (isset($pfpPath)) {
      return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/eparacati/' . ltrim($pfpPath, './'); // Remover '/eparacati/' em prod.
    }
  }

  public function deleteImage($equipmentId)
  {
    $equipmentInfo = $this->getInfo($equipmentId, ["image"]);

    if (!empty($equipmentInfo["image"])) {
      $imagePath = '../../../../public/images/profile_photos/' . $equipmentId . '.webp';

      if (file_exists($imagePath)) {
        unlink($imagePath);
      }

      $stmt = $this->conn->prepare("UPDATE equipments SET image = ? WHERE id = ?");
      $stmt->execute([null, $equipmentId]);
    }
  }
}
