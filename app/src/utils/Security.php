<?php
include_once 'Navigation.php';

use Godruoyi\Snowflake\Snowflake;

class Security
{

  private $conn;
  private $snowflake;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->snowflake = new Snowflake();
  }

  public static function sanitizeInput($data, $type = 'text')
  {
    if (is_string($data)) {
      $data = trim($data);
    }

    switch (strtolower($type)) {
      case 'email':
        $data = filter_var($data, FILTER_SANITIZE_EMAIL);
        break;

      case 'text':
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        break;

      case 'html':
        $allowed_tags = '<p><br><a><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6>';
        $data = strip_tags($data, $allowed_tags);
        break;

      case 'markdown':
      case 'md':
        $data = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data);
        $data = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $data);
        $data = preg_replace('/javascript:/i', '', $data);
        $data = preg_replace('/on\w+=/i', '', $data);
        break;

      case 'int':
        $data = filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        break;

      case 'float':
        $data = filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        break;

      default:
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    return $data;
  }

  public static function validateEmail($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
  }

  public static function isStrongPassword($password)
  {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    return preg_match($pattern, $password) === 1;
  }

  public function generateId(): int {
    return (int) $this->snowflake->id();
  }

  private static function getSecretKey()
  {
    static $secretKey;
    if ($secretKey === null) {
      $configPath = __DIR__ . '/../core/config.php';
      $config = require $configPath;
      $secretKey = $config['security']['secret_key'];
    }
    return $secretKey;
  }

  private static function getIV()
  {
    static $iv;
    if ($iv === null) {
      $configPath = __DIR__ . '/../core/config.php';
      $config = require $configPath;
      $iv = $config['security']['iv'];
    }
    return $iv;
  }

  public static function show($encodedId)
  {
    if (empty($encodedId)) {
      return null;
    }

    try {
      $decoded = base64_decode(strtr($encodedId, '-_', '+/'), true);
      if ($decoded === false || strlen($decoded) < 16) {
        return null;
      }

      $hmac = substr($decoded, 0, 16);
      $ciphertext = substr($decoded, 16);

      $calculatedHmac = substr(hash_hmac('sha256', $ciphertext, self::getSecretKey(), true), 0, 16);
      if (!hash_equals($hmac, $calculatedHmac)) {
        return null;
      }

      $iv = substr(hash('sha256', self::getIV(), true), 0, 16);
      $decrypted = openssl_decrypt($ciphertext, 'AES-256-CBC', self::getSecretKey(), OPENSSL_RAW_DATA, $iv);

      if ($decrypted === false) {
        return null;
      }

      return $decrypted;
    } catch (Exception $e) {
      return null;
    }
  }

  public static function hide($id)
  {
    if (empty($id)) {
      return '';
    }

    try {
      $id = (string) $id;

      $iv = substr(hash('sha256', self::getIV(), true), 0, 16);
      $encrypted = openssl_encrypt($id, 'AES-256-CBC', self::getSecretKey(), OPENSSL_RAW_DATA, $iv);
      if ($encrypted === false) {
        return '';
      }

      $hmac = substr(hash_hmac('sha256', $encrypted, self::getSecretKey(), true), 0, 16);

      $encoded = $hmac . $encrypted;

      return strtr(base64_encode($encoded), '+/', '-_');
    } catch (Exception $e) {
      return '';
    }
  }

  public static function passw($password)
  {
    $password = self::hide($password);
    return md5($password);
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
