<?php
$requiredRoles = ["gestao"];
$basepath = "../../";
require_once dirname(dirname(__DIR__)) . '/src/bootstrap.php';

$logId = isset($_GET['id']) ? Security::show($_GET['id']) : null;
if (!empty($logId)) {
  $currentLog = $logger->getInfo($logId);
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard - Registros</title>
  <link rel="stylesheet" href="../../../public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
    UI::renderPopup(true);
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
                <a href="./registros.php">
                  <span
                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Registros</span>
                </a>
              </div>
            </li>
            <?php if (isset($currentLog)): ?>
              <li aria-current="page">
                <div class="flex items-center">
                  <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4" />
                  </svg>
                  <span
                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400"><?php echo $currentLog['id']; ?></span>
                </div>
              </li>
            <?php endif; ?>
          </ol>
        </nav>
      </div>
    </header>

    <?php if (!empty($logId)) {
      if (empty($currentLog)) {
        echo '<main class="max-w-7xl mx-auto px-4 mt-5 flex justify-center items-center h-full"><div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-4 text-center"><h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200">Registro não encontrado</h2></div></main>';
      } else {
        include_once 'view/registro.php'; ?>
        <script src="view/js/registro.js"></script>
      <?php
      }
    } else { ?>

      <main>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
          <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                  <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i class="fas fa-history text-blue-500 mr-3"></i>
                    Histórico de Atividades
                  </h1>
                  <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Acompanhe todas as ações realizadas no sistema</p>
                </div>
              </div>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700">
              <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="relative inline-block text-left w-full sm:w-auto">
                  <button id="dropdownRadioButton" onclick="toggleDropdown()"
                    class="w-full sm:w-auto flex items-center justify-between gap-2 px-4 py-2.5 rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 focus:ring-2 focus:ring-blue-500/30 focus:outline-none">
                    <span class="flex items-center">
                      <i class="fas fa-filter text-blue-500 mr-2"></i>
                      <span class="font-medium">Filtrar por Ação</span>
                    </span>
                    <i class="fas fa-chevron-down text-gray-400 dark:text-gray-500 transition-transform duration-200"></i>
                  </button>

                  <div id="dropdownRadio"
                    class="z-50 hidden absolute mt-2 w-60 p-3 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 animate-slideDown">
                    <div class="mb-3 pb-2 border-b border-gray-100 dark:border-gray-700">
                      <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">Filtrar registros por tipo</h3>
                    </div>
                    <ul class="space-y-1 max-h-60 overflow-y-auto" aria-labelledby="dropdownRadioButton">
                      <li>
                        <div class="flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                          <input id="filter-radio-all" type="radio" value="" name="filter-radio" onclick="filterAction('')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                          <label for="filter-radio-all"
                            class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                            <span class="flex items-center">
                              <span class="h-2 w-2 inline-block bg-gray-300 dark:bg-gray-600 rounded-full mr-2"></span>
                              Todos os registros
                            </span>
                          </label>
                        </div>
                      </li>
                      <?php
                      $actions = $conn
                        ->query("SELECT DISTINCT action FROM logs")
                        ->fetchAll(PDO::FETCH_COLUMN);

                      foreach ($actions as $actionname) {
                        $safeAction = htmlspecialchars($actionname, ENT_QUOTES, "UTF-8");
                        $label = Format::actionName($actionname);

                        $colorClass = "bg-blue-400";
                        if (stripos($actionname, 'create') !== false) {
                          $colorClass = "bg-green-400";
                        } elseif (stripos($actionname, 'delete') !== false) {
                          $colorClass = "bg-red-400";
                        } elseif (stripos($actionname, 'update') !== false) {
                          $colorClass = "bg-yellow-400";
                        } elseif (stripos($actionname, 'view') !== false) {
                          $colorClass = "bg-purple-400";
                        }
                      ?>
                        <li>
                          <div class="flex items-center p-2 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <input id="filter-radio-<?= $safeAction ?>" type="radio" name="filter-radio"
                              value="<?= $safeAction ?>"
                              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                              onchange="filterLogs(this.value)">
                            <label for="filter-radio-<?= $safeAction ?>"
                              class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                              <span class="flex items-center">
                                <span class="h-2 w-2 inline-block <?= $colorClass ?> rounded-full mr-2"></span>
                                <?= htmlspecialchars($label, ENT_QUOTES, "UTF-8") ?>
                              </span>
                            </label>
                          </div>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </div>
                </div>

                <div class="relative w-full sm:w-72">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                  </div>
                  <input type="text" id="searchInput"
                    class="w-full pl-10 pr-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-200"
                    placeholder="Pesquisar nos registros...">
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="relative overflow-hidden">
              <div class="overflow-x-auto">
                <table class="w-full">
                  <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 text-left">
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Usuário</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">Ação</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">Tabela</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider hidden lg:table-cell">ID Alvo</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Descrição</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider hidden md:table-cell">IP</th>
                      <th scope="col" class="px-4 py-3.5 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Data/Hora</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php
                    $action = $_GET['action'] ?? null;
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $perPage = 15;

                    $filters = [];

                    if ($action) {
                      $filters['action'] = $action;
                    }

                    $result = $logger->getLogs($filters, $page, $perPage);
                    $logs = $result['data'];
                    $pagination = $result['pagination'];

                    foreach ($logs as $log) {
                      $log = array_map('htmlspecialchars', $log);
                      $log['user_name'] = strlen($log['user_name']) > 11 ? substr($log['user_name'], 0, 11) . '...' : $log['user_name'];
                      $log['message'] = strlen($log['message']) > 30 ? substr($log['message'], 0, 30) . '...' : $log['message'];

                      $actionColorClass = "bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300";
                      if (stripos($log['action'], 'create') !== false) {
                        $actionColorClass = "bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300";
                      } elseif (stripos($log['action'], 'delete') !== false) {
                        $actionColorClass = "bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300";
                      } elseif (stripos($log['action'], 'update') !== false) {
                        $actionColorClass = "bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300";
                      } elseif (stripos($log['action'], 'view') !== false) {
                        $actionColorClass = "bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300";
                      }
                    ?>
                      <tr class="group transition-all duration-200 hover:bg-blue-50/40 dark:hover:bg-blue-900/10 cursor-pointer"
                        onclick="window.location.href='./registros.php?id=<?= Security::hide($log['id']) ?>'">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-200">
                          <span class="font-mono">#<?= $log['id'] ?></span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                          <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-2 overflow-hidden">
                              <?php
                                $iconClass = ($log['ip_address'] === '127.0.0.1') ? 'server' : 'user';
                              ?>
                              <i class="fas fa-<?= $iconClass ?> text-gray-500 dark:text-gray-400"></i>
                            </div>
                            <div>
                              <div class="font-medium"><?= $log['user_name'] ?></div>
                              <div class="text-xs text-gray-500 dark:text-gray-400">ID: <?= $log['user_id'] ?></div>
                            </div>
                          </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 hidden md:table-cell">
                          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $actionColorClass ?>">
                            <?= Format::actionName($log['action']) ?>
                          </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 hidden lg:table-cell"><?= Format::tableName($log['target_table']) ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 hidden lg:table-cell"><?= $log['target_id'] ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300"><?= $log['message'] ?></td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 hidden md:table-cell">
                          <span class="font-mono text-xs"><?= $log['ip_address'] ?></span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                          <div class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-1.5"></i>
                            <span><?= Format::date($log['timestamp']) ?></span>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>

                    <?php if (empty($logs)): ?>
                      <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                          <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-search text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                            <p class="text-lg font-medium">Nenhum registro encontrado</p>
                            <p class="text-sm mt-1">Tente ajustar seus filtros ou critérios de pesquisa</p>
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <?php if ($pagination['total_pages'] > 1): ?>
                <div class="px-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700">
                  <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                      <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                        Mostrando <span class="font-semibold text-gray-800 dark:text-gray-200"><?= (($pagination['current_page'] - 1) * $pagination['per_page']) + 1 ?></span> a
                        <span class="font-semibold text-gray-800 dark:text-gray-200"><?= min($pagination['current_page'] * $pagination['per_page'], $pagination['total']) ?></span> de
                        <span class="font-semibold text-gray-800 dark:text-gray-200"><?= $pagination['total'] ?></span> resultados
                      </p>
                    </div>
                    <div>
                      <nav class="inline-flex shadow-sm rounded-lg overflow-hidden" aria-label="Paginação">
                        <?php
                        $queryParams = $_GET;
                        ?>

                        <a href="<?= $pagination['current_page'] > 1 ? '?' . http_build_query(array_merge($queryParams, ['page' => $pagination['current_page'] - 1])) : '#' ?>"
                          class="<?= $pagination['current_page'] <= 1 ? 'pointer-events-none opacity-50' : '' ?> relative inline-flex items-center justify-center w-10 h-10 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                          <span class="sr-only">Anterior</span>
                          <i class="fas fa-chevron-left text-sm"></i>
                        </a>

                        <?php
                        $startPage = max(1, $pagination['current_page'] - 2);
                        $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);

                        for ($i = $startPage; $i <= $endPage; $i++):
                          $isCurrentPage = $i === $pagination['current_page'];
                        ?>
                          <a href="<?= '?' . http_build_query(array_merge($queryParams, ['page' => $i])) ?>"
                            class="relative inline-flex items-center justify-center w-10 h-10 border border-gray-200 dark:border-gray-700 <?= $isCurrentPage ? 'bg-blue-600 text-white font-semibold z-10 border-blue-600 dark:border-blue-600' : 'text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700' ?> transition-colors">
                            <?= $i ?>
                          </a>
                        <?php endfor; ?>

                        <a href="<?= $pagination['current_page'] < $pagination['total_pages'] ? '?' . http_build_query(array_merge($queryParams, ['page' => $pagination['current_page'] + 1])) : '#' ?>"
                          class="<?= $pagination['current_page'] >= $pagination['total_pages'] ? 'pointer-events-none opacity-50' : '' ?> relative inline-flex items-center justify-center w-10 h-10 text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                          <span class="sr-only">Próximo</span>
                          <i class="fas fa-chevron-right text-sm"></i>
                        </a>
                      </nav>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div class="mt-4 text-xs text-center text-gray-500 dark:text-gray-400">
            <p>As informações exibidas aqui são registros de atividades do sistema para fins de auditoria e segurança.</p>
          </div>
        </div>
      </main>

      <script>
        function toggleDropdown() {
          const dropdown = document.getElementById('dropdownRadio');
          dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
          const dropdown = document.getElementById('dropdownRadio');
          const button = document.getElementById('dropdownRadioButton');
          if (!dropdown.contains(event.target) && !button.contains(event.target) && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
          }
        });

        document.getElementById('dropdownRadioButton').addEventListener('click', function() {
          const icon = this.querySelector('.fa-chevron-down');
          icon.classList.toggle('rotate-180');
        });
      </script>
  </div>

  <script src="../../../public/js/dashboard/logs/filterDropdown.js"></script>
  <script src="../../../public/js/dashboard/logs/searchBarController.js"></script>
<?php } ?>
</body>

</html>