<?php
$requiredRoles = ['gremio', 'professor', 'pdt', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard</title>
  <link href="../../public/css/output.css" rel="stylesheet">
  <link href="../../public/assets/fontawesome/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../public/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-200 dark:from-gray-900 dark:to-gray-950 text-gray-900 dark:text-gray-100 min-h-screen flex flex-col">
  <?php UI::renderNavbar($currentUser, '../', 'Dashboard', 'blue', 'altlogo.svg');
  UI::renderAlerts(true); ?>
  <main class="flex-1 w-full max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8 relative z-10">
    <div class="absolute top-0 left-0 w-full h-72 bg-gradient-to-tr from-blue-700/30 via-purple-700/20 to-pink-600/10 dark:from-blue-900/40 dark:via-purple-900/30 dark:to-pink-900/20 -z-10 rounded-b-3xl blur-sm"></div>
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
      <div>
        <h1 class="text-4xl md:text-5xl font-black bg-gradient-to-r from-blue-700 via-purple-600 to-pink-500 bg-clip-text text-transparent drop-shadow-lg tracking-tight">Dashboard <span class="text-xl font-semibold text-gray-700 dark:text-gray-300">(<?= Format::roleName($currentUser['role']) ?>)</span></h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">Olá, <span class="font-bold text-blue-700 dark:text-blue-300"><?= $currentUser['name']; ?></span>! Bem-vindo(a) ao seu painel de controle.</p>
      </div>
      <div class="flex items-center gap-4 bg-white/80 dark:bg-gray-900/80 rounded-2xl shadow-lg px-6 py-4 border border-blue-100 dark:border-blue-900/30 backdrop-blur-md">
        <div class="bg-blue-100 dark:bg-blue-900/60 p-3 rounded-xl flex items-center justify-center">
          <i class="fas fa-clock text-blue-600 dark:text-blue-400 text-2xl"></i>
        </div>
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Data atual</p>
          <p class="font-bold text-gray-800 dark:text-gray-200 text-lg"><?= date('d/m/Y') ?></p>
        </div>
      </div>
    </div>

    <?php require_once 'view/' . $currentUser['role'] . '.php'; ?>

  </main>
  <?php UI::renderFooter('../',); ?>
  <div class="fixed inset-0 bg-gradient-to-br from-blue-500/5 to-purple-500/5 pointer-events-none -z-10"></div>
</body>

</html>