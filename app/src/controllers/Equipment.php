<?php
require_once 'core/conn.php';

require_once 'utils/Security.php';
require_once 'utils/Navigation.php';
require_once 'utils/fileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class EquipmentController
{
  private $conn;
  private $security;
  private $fileUploader;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->security = new Security($conn);
    $this->fileUploader = new FileUploader();
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

  public function getInfo($id, $fields = [])
  {
    $defaultFields = ['id', 'name', 'status', 'type', 'description', 'image', 'created_at'];

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
    $sql = "SELECT $fields FROM equipments WHERE id =?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
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
            "Campo inválido: $field",
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

  public function register($name, $type, $status, $description = null, $image = null, $alerts = true)
  {
    $validTypes = ['notebook', 'extensao', 'sala', 'projetor', 'outro'];
    $validStatuses = ['disponivel', 'indisponivel'];

    if (!in_array($type, $validTypes)) {
      if ($alerts) {
        Navigation::alert(
          "Tipo inválido: $type",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    }

    if (empty($status)) {
      $status = 'disponivel';
    } elseif (!in_array($status, $validStatuses)) {
      if ($alerts) {
        Navigation::alert(
          "Status inválido: $status",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    }

    $id = $this->security->generateUniqueId(8, "equipments");
    $created_at = date("d-m-Y H:i:s");

    if (empty($name) || empty($type) && $alerts) {
      Navigation::alert(
        "Preencha todos os campos!",
        $_SERVER['HTTP_REFERER']
      );
      return false;
    }

    $sql = "SELECT id FROM equipments WHERE name = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name]);

    if ($stmt->fetchColumn()) {
      if ($alerts) {
        Navigation::alert(
          "Já existe um equipamento com esse nome!",
          $_SERVER['HTTP_REFERER']
        );
      }
      return false;
    } else {
      if ($image) {
        $image = $this->addPhoto($image, $id);
      }

      $sql = 'INSERT INTO equipments (id, name, type, status, description, image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)';
      $stmt = $this->conn->prepare($sql);
      $data = [
        $id,
        $name,
        $type,
        $status,
        $description,
        $image,
        $created_at
      ];
      $stmt->execute($data);
      return $id;
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

      foreach ($rows as $index => $row) {
        try {
          if (empty($row[0]) || empty($row[1])) {
            $results['errors'][] = "Linha " . ($index + 2) . ": Campos obrigatórios faltando";
            continue;
          }

          $id = $this->security->generateUniqueId(8, 'equipments');
          $this->register($row[0], $row[1], $row[2], $row[3], !empty($row[4]) ? $row[4] : null, false);

          $results['success']++;
          $results['created_equipments'][$row[0]] = $id;
        } catch (Exception $e) {
          $results['errors'][] = "Linha " . ($index + 2) . ": " . $e->getMessage();
        }
      }

      return $results;
    } catch (Exception $e) {
      Navigation::alert("Erro ao processar arquivo: " . $e->getMessage());
    }
  }

  private function addPhoto($imageFile, $equipmentId)
  {
    $uploadPath = '../../../../public/assets/images/equipment_photos/';

    $pfpPath = $this->fileUploader->uploadImage(
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

  public function deleteImage($equipmentId)
  {
    $equipmentInfo = $this->getInfo($equipmentId, ["image"]);

    if (!empty($equipmentInfo["image"])) {
      $imagePath = '../../../../public/assets/images/profile_photos/' . $equipmentId . '.webp';

      if (file_exists($imagePath)) {
        unlink($imagePath);
      }

      $stmt = $this->conn->prepare("UPDATE equipments SET image = ? WHERE id = ?");
      $stmt->execute([null, $equipmentId]);
    }
  }

  public function delete($id)
  {
    $this->deleteImage($id);

    $sql = "DELETE FROM equipments WHERE id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$id]);
  }
}
