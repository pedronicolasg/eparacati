<?php
$allowUnauthenticatedAccess = true;
require_once "../../bootstrap.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Navigation::alert(
    'Método inválido',
    "",
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}

try {
  $email = $_POST['email'] ?? null;
  $password = $_POST['password'] ?? null;

  if (!$email || !$password) {
    Navigation::alert(
      'Dados Incompletos',
      'Email e senha são obrigatórios.',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  if (!Security::validateEmail($email)) {
    Navigation::alert(
      'Email Inválido',
      'O email enviado é inválido, tente novamente.',
      'error',
      $_SERVER['HTTP_REFERER']
    );
    exit;
  }

  $email = Security::sanitizeInput($email, 'email');
  $password = Security::passw($password);

  $userModel->login($email, $password);

  $user = $userModel->getInfo($email, 'email', ['name']);
  $logger->action(
    $user['id'],
    'login',
    'users',
    $user['id'],
    "'{$user['name']}' logou em sua conta",
    Security::getIp()
  );

  if (!Security::isStrongPassword($_POST['password'])) {
    $_SESSION['alert'][] = [
      'titulo' => 'Senha Fraca',
      'mensagem' => 'Sua senha é considerada fraca. Recomendamos que você a altere para uma senha mais forte.',
      'tipo' => 'warning'
    ];
  }

  Navigation::alert(
    'Login realizado com sucesso!',
    'Seja bem-vindo de volta, ' . htmlspecialchars($user['name']) . '!',
    'success',
    ($user['role'] === 'gestao' ? '../../../dashboard/' : '../../../agendae/')
  );
} catch (Exception $e) {
  Navigation::alert(
    'Erro de Login',
    $e->getMessage(),
    'error',
    $_SERVER['HTTP_REFERER']
  );
  exit;
}
