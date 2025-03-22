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
  <link rel="stylesheet" href="../../../public/assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="shortcut icon" href="../../../public/assets/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="min-h-full">
    <?php UI::renderNavbar(
      $currentUser,
      "../../",
      "Dashboard",
      "blue",
      "altlogo.svg"
    ); ?>

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
        <div class="max-w-7xl mx-auto px-4 mt-5">
          <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-5">
            <div class="p-4 flex items-center justify-between gap-4">
              <div class="relative inline-block text-left">
                <button id="dropdownRadioButton" onclick="toggleDropdown()"
                  class="h-10 inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                  type="button">
                  <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                      d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                  </svg>
                  Ação
                  <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 4 4 4-4" />
                  </svg>
                </button>


                <div id="dropdownRadio"
                  class="z-50 hidden absolute mt-2 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdownRadioButton">
                    <li>
                      <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        <input id="filter-radio-all" type="radio" value="" name="filter-radio" onclick="filterAction('')"
                          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="filter-radio-all"
                          class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Todos</label>
                      </div>
                    </li>
                    <?php
                    $actions = $conn
                      ->query("SELECT DISTINCT action FROM logs")
                      ->fetchAll(PDO::FETCH_COLUMN);

                    foreach ($actions as $actionname) {
                      $safeAction = htmlspecialchars($actionname, ENT_QUOTES, "UTF-8");
                      $label = Format::actionName($actionname);
                    ?>
                      <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                          <input id="filter-radio-<?= $safeAction ?>" type="radio" name="filter-radio"
                            value="<?= $safeAction ?>"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            onchange="filterLogs(this.value)">
                          <label for="filter-radio-<?= $safeAction ?>"
                            class="ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?= htmlspecialchars($label, ENT_QUOTES, "UTF-8") ?></label>
                        </div>
                      </li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>

              <div class="flex items-center gap-4">
                <div class="relative w-72">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search w-4 h-4 text-gray-400"></i>
                  </div>
                  <input type="text"
                    class="h-10 w-full pl-10 pr-4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Pesquisar registros">
                </div>
              </div>
            </div>

            <div class="bg-white dark:bg-[#1d242c] max-w-7xl mx-auto px-4 py-8 overflow-x-auto">
              <table class="w-full border-collapse min-w-max">
                <thead>
                  <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="text-gray-500 dark:text-gray-500 pr-4 py-2">ID</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Usuário ID</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Nome do Usuário</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Ação Realizada</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Tabela Alvo</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">ID Alvo</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Descrição</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Endereço IP</th>
                    <th class="px-4 py-2 text-blue-600 dark:text-[#3182ce]">Data e Hora</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $action = $_GET['action'] ?? null;
                  $logs = $logger->getLogs(['action' => $action]);

                  foreach ($logs as $log) {
                    $log = array_map('htmlspecialchars', $log);
                    $log['user_name'] = strlen($log['user_name']) > 11 ? substr($log['user_name'], 0, 11) . '...' : $log['user_name'];
                    $log['message'] = strlen($log['message']) > 30 ? substr($log['message'], 0, 30) . '...' : $log['message'];
                  ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-[#2a323c] border-b border-gray-200 dark:border-gray-700/50">
                    <tr class="hover:bg-gray-100 dark:hover:bg-[#2a323c] border-b border-gray-200 dark:border-gray-700/50 cursor-pointer" onclick="window.location.href='./registros.php?id=<?= Security::hide($log['id']) ?>'">
                      <td class="text-gray-500 dark:text-gray-500 pr-4 py-2 text-right"><?= $log['id'] ?></td>
                      <td class="px-4 py-2"><?= $log['user_id'] ?></td>
                      <td class="px-4 py-2"><?= $log['user_name'] ?></td>
                      <td class="px-4 py-2"><?= Format::actionName($log['action']) ?></td>
                      <td class="px-4 py-2"><?= Format::tableName($log['target_table']) ?></td>
                      <td class="px-4 py-2"><?= $log['target_id'] ?></td>
                      <td class="px-4 py-2"><?= $log['message'] ?></td>
                      <td class="px-4 py-2"><?= $log['ip_address'] ?></td>
                      <td class="px-4 py-2">[ <?= $log['timestamp'] ?> ]</td>
                    </tr>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
  </div>

  <script src="../../../public/assets/js/dashboard/logs/filterDropdown.js"></script>
  <script src="../../../public/assets/js/dashboard/logs/searchBarController.js"></script>
<?php } ?>
</body>

</html>