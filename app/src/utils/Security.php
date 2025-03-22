<?php
include_once 'Navigation.php';

class Security
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

    $invalidChars = [];
    if (preg_match_all('/[\'";#\-<>]/', $input, $matches)) {
      $invalidChars = array_unique($matches[0]);
      $invalidCharsStr = implode(', ', $invalidChars);
      Navigation::alert("Caracteres inválidos: " . $invalidCharsStr . ". Por favor tente novamente.", $_SERVER['HTTP_REFERER']);
    }

    return $input;
  }

  public function generateUniqueId($digits, $tableName, $columnName = 'id'): int
  {
    if ($digits <= 0) {
      throw new InvalidArgumentException('O número de dígitos deve ser maior que 0.');
    }

    $min = (int) str_pad('1', $digits, '0');
    $max = (int) str_pad('9', $digits, '9');

    do {
      $randomId = random_int($min, $max);
      $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$tableName} WHERE {$columnName} = :id");
      $stmt->bindParam(':id', $randomId, PDO::PARAM_INT);
      $stmt->execute();

      $exists = $stmt->fetchColumn() > 0;
    } while ($exists);

    return $randomId;
  }

  public static function hide($tx)
  {
    if (!empty($tx)) {
      $tx = base64_encode(base64_encode(base64_encode($tx)));
    }
    return $tx;
  }

  public static function show($tx)
  {
    if (!empty($tx)) {
      $tx = base64_decode(base64_decode(base64_decode(base64_decode(base64_encode($tx)))));
    }
    return $tx;
  }

  public static function passw($senha)
  {
    $senha = Security::hide($senha);
    return md5($senha);
  }

  public static function getIp()
  {
    $headers = ['HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];
    foreach ($headers as $header) {
      if (!empty($_SERVER[$header])) {
        $ip = $_SERVER[$header];
        if (strpos($ip, ',') !== false) {
          $ip = trim(explode(',', $ip)[0]);
        }
        return $ip;
      }
    }
    return '0.0.0.0';
  }
}
