<?php
$config = include_once 'config.php';

try {
  $conn = new PDO(
    "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
    $config['db']['username'],
    $config['db']['password']
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}
