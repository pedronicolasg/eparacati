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
    echo "<meta charset='UTF-8' />
    <script type='text/javascript'>
      location.href='$location';
    </script>";
    exit;
  }

  public static function alert($message, $location = null)
  {
?>
    <meta charset='UTF-8' />
    <script type='text/javascript'>
      alert('<?= $message ?>');
      <?php if (isset($location)) { ?>
        location.href = '<?= $location ?>';
      <?php } ?>
    </script>
<?php
    exit;
  }

  public static function formatRoleName($role){
    $roleMap = [
      'aluno' => 'Aluno',
      'professor' => 'Professor',
      'gremio' => 'Grêmio',
      'gestao' => 'Gestão',
      'pdt' => 'PDT',
      'funcionario' => 'Funcionário',
  ];

  return $roleMap[$role] ?? ucfirst($role);
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
