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

  public static function redirect($location)
  {
    self::outputScript("location.href='$location';");
  }

  public static function alert($message, $location = null)
  {
    $script = "alert('$message');";
    if ($location !== null) {
      $script .= "location.href='$location';";
    }
    self::outputScript($script);
  }

  private static function outputScript($script)
  {
    echo "<meta charset='UTF-8' />
    <script type='text/javascript'>
      $script
    </script>";
    exit;
  }

  public static function generateDefaultPFP($userName)
  {
    $formatted_name = preg_replace(
      "/[^a-zA-Z]/",
      "",
      str_replace(" ", "", $userName)
    );
    return "https://ui-avatars.com/api/?name=$formatted_name&background=random&color=fff";
  }

  public static function formatRoleName($role, $forUser = false)
  {
    $roleMap = [
      'aluno' => 'Aluno',
      'lider' => 'Líder',
      'vice_lider' => 'Vice-Líder',
      'gremio' => 'Grêmio',
      'professor' => 'Professor',
      'pdt' => 'PDT',
      'funcionario' => 'Funcionário',
      'gestao' => 'Gestão',
    ];

    if ($forUser) {
      array_walk($roleMap, function (&$role) {
        $role = str_replace(['Aluno', 'Professor', 'Funcionário', 'Gestão'], ['Aluno(a)', 'Professor(a)', 'Funcionário(a)', 'Gestor(a)'], $role);
      });
    }

    return $roleMap[$role] ?? ucfirst($role);
  }

  public function generateUniqueId(int $digits, string $tableName, string $columnName = 'id'): int
  {
    if ($digits <= 0) {
      throw new InvalidArgumentException('The number of digits must be greater than 0.');
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
    $senha = Utils::hide($senha);
    return md5($senha);
  }

  public static function getIp()
  {
    $headers = [
      'HTTP_CLIENT_IP',
      'HTTP_X_FORWARDED_FOR',
      'HTTP_X_FORWARDED',
      'HTTP_FORWARDED_FOR',
      'HTTP_FORWARDED',
      'REMOTE_ADDR'
    ];

    foreach ($headers as $header) {
      if (!empty($_SERVER[$header])) {
        // Se tiver múltiplos IPs, pega o primeiro
        $ips = explode(',', $_SERVER[$header]);
        return trim($ips[0]);
      }
    }

    return '0.0.0.0';
  }
}
