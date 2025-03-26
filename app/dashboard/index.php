<?php
$requiredRoles = ['gremio', 'professor', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard</title>
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../public/assets/images/altlogo.svg" type="image/x-icon">
  <style>
    .metric-blue::before {
      background: #3b82f6;
    }

    .metric-green::before {
      background: #10b981;
    }

    .metric-purple::before {
      background: #8b5cf6;
    }

    .metric-cyan::before {
      background: #06b6d4;
    }
  </style>
</head>

<body class="bg-gray-100 dark:bg-slate-900 text-gray-900 dark:text-gray-100 transition-colors duration-200">
  <?php UI::renderNavbar($currentUser, '../', 'Dashboard', 'blue', 'altlogo.svg') ?>

  <main class="container mx-auto px-4 py-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard (<?= Format::roleName($currentUser['role']) ?>)</h1>
      <p class="text-gray-600 dark:text-gray-400 mt-1">Boas-vindas ao seu painel de controle <?= $currentUser['name']; ?>.</p>
    </div>

    <section class="mb-8">
      <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white border-b border-blue-500 pb-2 inline-block">Métricas Principais</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php include_once 'components/metrics.php'; ?>
      </div>
    </section>

    <!-- Equipment Reservations -->
    <section class="mb-8">
      <div class="bg-white dark:bg-slate-800 rounded-lg overflow-hidden shadow-sm dark:shadow-none border border-gray-200 dark:border-slate-700">
        <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-slate-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Próximas Reservas de Equipamentos</h2>
          <a href="#" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 hover:underline flex items-center text-sm">
            <span>Ver Todas</span>
            <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
        <div class="overflow-x-auto">
          <?php include_once 'components/bookings.php'; ?>
        </div>
      </div>
    </section>

    <!-- APPS Section -->
    <section class="mb-8">
      <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white border-b border-blue-500 pb-2 inline-block">APPS</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php include_once 'components/apps.php'; ?>
      </div>
    </section>

    <!-- Two Column Layout for Actions and Notifications -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Quick Actions -->
      <section class="lg:col-span-2">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white border-b border-blue-500 pb-2 inline-block">Ações Rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php include_once 'components/actions.php'; ?>
        </div>
      </section>

      <section class="lg:col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded-lg overflow-hidden h-full shadow-sm dark:shadow-none border border-gray-200 dark:border-slate-700">
          <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-slate-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Registros Recentes</h2>
            <a href="pages/registros.php" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 text-sm hover:underline">Ver Todos</a>
          </div>
          <div class="p-4">
            <div class="space-y-3">
              <?php include_once 'components/logs.php'; ?>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php UI::renderFooter('../',); ?>
</body>

</html>