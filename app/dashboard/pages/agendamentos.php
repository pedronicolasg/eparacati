<?php
$requiredRoles = ["gestao"];
$basepath = "../../";
require_once dirname(dirname(__DIR__)) . '/src/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard - Agendamentos</title>
  <link rel="stylesheet" href="../../../public/css/output.css">
  <link href="../../../public/assets/fontawesome/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../public/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="min-h-full">
    <?php UI::renderNavbar(
      $currentUser,
      "../../",
      "Dashboard",
      "blue",
      "altlogo.svg"
    );
    UI::renderAlerts(true);
    ?>

    <header class="bg-white shadow-lg dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-200">Dashboard
          (<?php echo Format::roleName($currentUser["role"]); ?>)</h1>


        <nav class="flex" style="margin-top: 15px;" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
              <a href="../index.php"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                <i class="fas fa-pager w-3 h-3 me-2.5"></i>
                Dashboard
              </a>
            </li>
            <li aria-current="page">
              <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
                </svg>
                <a href="./agendamentos.php">
                  <span
                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Agendamentos</span>
                </a>
              </div>
            </li>
          </ol>
        </nav>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto px-4 mt-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
          <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Gerenciamento de Agendamentos</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Visualize e gerencie todos os agendamentos da plataforma</p>
          </div>

          <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative w-full">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fas fa-search text-indigo-500 dark:text-indigo-400"></i>
              </div>
              <input type="text"
                class="h-12 w-full pl-12 pr-4 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 rounded-xl border-2 border-indigo-100 dark:border-indigo-900/30 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:focus:ring-indigo-800 dark:focus:ring-opacity-30 shadow-sm transition-all duration-300 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                placeholder="Pesquisar agendamentos">
            </div>
          </div>
        </div>

        <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100/80 dark:border-gray-700/80 overflow-hidden mb-8 transition-all duration-500 hover:shadow-2xl">
          <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-100 dark:divide-gray-700 border-b border-gray-100 dark:border-gray-700">
            <div class="p-6 text-center">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total</p>
              <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400"><?php echo $scheduleModel->count(); ?></p>
            </div>
            <div class="p-6 text-center">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Hoje</p>
              <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400"><?php echo $scheduleModel->count([], 'today'); ?></p>
            </div>
            <div class="p-6 text-center">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Semana</p>
              <p class="text-3xl font-bold text-amber-600 dark:text-amber-400"><?php echo $scheduleModel->count([], 'week'); ?></p>
            </div>
            <div class="p-6 text-center">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Mês</p>
              <p class="text-3xl font-bold text-purple-600 dark:text-purple-400"><?php echo $scheduleModel->count([], 'month'); ?></p>
            </div>
          </div>

          <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
              <?php
              $type = $_GET['type'] ?? null;
              $ui->renderBookings('../../../');
              ?>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="../../../public/js/dashboard/booking/searchBarController.js"></script>
</body>

</html>