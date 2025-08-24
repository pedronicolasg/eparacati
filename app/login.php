<?php
$allowUnauthenticatedAccess = true;
require_once __DIR__ . "/src/bootstrap.php";
$security = new Security($conn);

$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'gestao'");
$stmt->execute();
$gestaoCount = $stmt->fetchColumn();

$stmt = $conn->prepare("SELECT COUNT(*) FROM setupKeys WHERE active = 1");
$stmt->execute();
$availableKeysCount = $stmt->fetchColumn();

if ($gestaoCount == 0 && $availableKeysCount > 0) {
  Navigation::redirect('../setup.php');
  exit;
} else if ($gestaoCount == 0 && $availableKeysCount == 0) {
  Navigation::redirect('../indev.php');
  exit;
} else if (isset($_SESSION['id'])) {
  Navigation::redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Login</title>
  <link rel="shortcut icon" href="../public/images/logo.svg" type="image/x-icon">
  <link href="../public/css/output.css" rel="stylesheet">
  <link href="../public/assets/fontawesome/css/all.min.css" rel="stylesheet" />
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
  <?php UI::renderAlerts(true); ?>

  <div class="absolute top-6 left-6 z-20">
    <a href="../" class="flex items-center space-x-2 text-gray-700 dark:text-gray-200 hover:text-green-500 dark:hover:text-green-400 transition-colors duration-300">
      <i class="fas fa-arrow-left"></i>
      <span class="text-sm font-medium">Voltar ao site</span>
    </a>
  </div>

  <div class="absolute top-6 right-6 z-20">
    <button id="themeToggle" onclick="toggleDarkMode()"
      class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300">
      <i id="themeIcon" class="fas fa-moon"></i>
    </button>
  </div>

  <div class="absolute top-0 right-0 w-80 h-80 bg-green-400 dark:bg-green-500 rounded-full filter blur-3xl opacity-20 dark:opacity-10 transform -translate-y-20 translate-x-20"></div>
  <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400 dark:bg-blue-500 rounded-full filter blur-3xl opacity-20 dark:opacity-10 transform translate-y-20 -translate-x-20"></div>

  <div class="w-full max-w-md z-10">
    <div class="text-center mb-8">
      <img src="../public/images/logo.svg" alt="EP Aracati Logo" class="h-24 mx-auto mb-4 transform transition-transform duration-300 hover:scale-105">
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Bem-vindo</h2>
      <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Acesse sua conta com suas credenciais</p>
    </div>

    <div class="bg-white/80 backdrop-blur-lg border border-gray-200 dark:bg-white/10 dark:border-white/10 rounded-2xl p-8 shadow-xl">
      <form class="space-y-6" action="src/controllers/user/login.php" method="POST">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
          <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-envelope text-gray-500 dark:text-gray-400"></i>
            </div>
            <input id="email" name="email" type="email" required
              class="w-full pl-10 pr-4 py-3 bg-white/50 dark:bg-white/10 border border-gray-300 dark:border-white/20 rounded-lg 
              text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400 dark:focus:ring-green-400 focus:border-transparent 
              transition-all duration-200"
              placeholder="seu@email.com">
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Senha</label>
          <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-gray-500 dark:text-gray-400"></i>
            </div>
            <input id="password" name="password" type="password" required
              class="w-full pl-10 pr-12 py-3 bg-white/50 dark:bg-white/10 border border-gray-300 dark:border-white/20 rounded-lg 
              text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-400 dark:focus:ring-green-400 focus:border-transparent 
              transition-all duration-200"
              placeholder="••••••••">
            <button type="button" onclick="togglePassword()"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
              <i id="eyeIcon" class="fas fa-eye"></i>
            </button>
          </div>
        </div>

        <div>
          <button type="submit"
            class="w-full flex justify-center items-center py-3 px-4 bg-gradient-to-r from-green-600 to-green-700 
            text-white font-medium rounded-lg hover:from-green-500 hover:to-green-600 focus:outline-none 
            focus:ring-2 focus:ring-offset-2 focus:ring-green-400 dark:focus:ring-green-400 transition-all duration-300 transform hover:-translate-y-1 shadow-md">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Entrar
          </button>
        </div>
      </form>
    </div>

    <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
      <p>&copy; 2025 E.E.E.P. Aracati. Desenvolvido por <a href="https://github.com/pedronicolasg" class="text-green-600 dark:text-green-700">Pedro Nícolas Gomes de Souza</a>.</p>
    </div>
  </div>

  <script src="../public/js/login.js"></script>
</body>

</html>