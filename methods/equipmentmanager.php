<?php
require_once 'conn.php';
require_once 'utils.php';
require_once 'fileUploader.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class EquipmentManager
{
  private $conn;
  private $utils;
  private $fileUploader;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->utils = new Utils($conn);
    $this->fileUploader = new FileUploader();
  }

  public function getInfo($id, $fields = [])
  {
    $defaultFields = ['id', 'name', 'status', 'type', 'description', 'image', 'created_at'];

    if (empty($fields)) {
      $fields = $defaultFields;
    } else {
      foreach ($fields as $field) {
        if (!in_array($field, $defaultFields)) {
          Utils::alert(
            "Campo inválido: $field",
            "../../../dashboard/pages/equipamentos.php"
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

  public function register($name, $type, $status, $description = null, $image = null, $alerts = true)
  {
    $validTypes = ['notebook', 'extensao', 'sala', 'projetor', 'outro'];
    $validStatuses = ['disponivel', 'indisponivel'];

    if (!in_array($type, $validTypes)) {
      if ($alerts) {
        Utils::alert(
          "Tipo inválido: $type",
          "../../../dashboard/pages/equipamentos.php"
        );
      }
      return false;
    }

    if (empty($status)) {
      $status = 'disponivel';
    } elseif (!in_array($status, $validStatuses)) {
      if ($alerts) {
        Utils::alert(
          "Status inválido: $status",
          "../../../dashboard/pages/equipamentos.php"
        );
      }
      return false;
    }

    $id = $this->utils->generateUniqueId(8, "equipments");
    $created_at = date("d-m-Y H:i:s");

    if (empty($name) || empty($type) && $alerts) {
      Utils::alert(
        "Preencha todos os campos!",
        "../../../dashboard/pages/equipamentos.php"
      );
      return false;
    }

    $sql = "SELECT id FROM equipments WHERE name = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$name]);

    if ($stmt->fetchColumn()) {
      if ($alerts) {
        Utils::alert(
          "Já existe um equipamento com esse nome!",
          "../../../dashboard/pages/equipamentos.php"
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

          $id = $this->utils->generateUniqueId(8, 'equipments');
          $this->register($row[0], $row[1], $row[2], $row[3], !empty($row[4]) ? $row[4] : null, false);

          $results['success']++;
          $results['created_equipments'][$row[0]] = $id;
        } catch (Exception $e) {
          $results['errors'][] = "Linha " . ($index + 2) . ": " . $e->getMessage();
        }
      }

      return $results;
    } catch (Exception $e) {
      Utils::alert("Erro ao processar arquivo: " . $e->getMessage());
    }
  }

  private function addPhoto($imageFile, $equipmentId)
  {
    $uploadPath = '../../../assets/images/equipment_photos/';

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
        } else {
          $updateFields[] = "image = :image";
          $params[":image"] = Utils::generateDefaultPFP($currentUser['name']);
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
      $imagePath = '../../../assets/images/profile_photos/' . $equipmentId . '.webp';

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
