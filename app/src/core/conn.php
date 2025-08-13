<?php
date_default_timezone_set('America/Fortaleza');

$config = include_once 'config.php';

if (!isset($config['db']['host'], $config['db']['port'], $config['db']['dbname'], $config['db']['username'], $config['db']['password'], $config['security']['secret_key'], $config['security']['iv'])) {
  die('Erro: Arquivo de configurações incompleto.');
}

try {
  $conn = new PDO(
    "mysql:host={$config['db']['host']}:{$config['db']['port']};dbname={$config['db']['dbname']};charset=utf8mb4",
    $config['db']['username'],
    $config['db']['password']
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}
