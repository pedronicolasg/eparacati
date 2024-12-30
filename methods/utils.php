<?php

class Utils
{
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public static function sanitizeInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    if (preg_match('/[\'";#\-]/', $input)) {
      die("Entrada inválida detectada.");
    }

    return $input;
  }

  public static function alertAndRedirect($message, $location)
  {
    echo "<meta charset='UTF-8' />";
    echo "<script type='text/javascript'>alert('$message'); location.href='$location';</script>";
    exit;
  }

  public function generateUniqueId(int $digits, string $tableName, string $columnName = 'id'): int
  {
    if ($digits <= 0) {
      throw new InvalidArgumentException('The number of digits must be greater than 0.');
    }

    $min = (int) str_pad('1', $digits, '0'); // Valor mínimo (ex: 1 para 8 dígitos seria 10000000)
    $max = (int) str_pad('9', $digits, '9'); // Valor máximo (ex: 8 dígitos seria 99999999)

    do {
      $randomId = random_int($min, $max);
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$tableName} WHERE {$columnName} = :id");
      $stmt->bindParam(':id', $randomId, PDO::PARAM_INT);
      $stmt->execute();

      $exists = $stmt->fetchColumn() > 0;
    } while ($exists);

    return $randomId;
  }
}
