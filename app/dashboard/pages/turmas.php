<?php
$requiredRoles = ["gestao"];
$basepath = "../../";
require_once dirname(dirname(__DIR__)) . '/src/bootstrap.php';

$viewClassId = isset($_GET['id']) ? Security::show($_GET['id']) : null;
$itemsPerPage = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedGrade = isset($_GET["grade"]) ? $_GET["grade"] : null;

if (isset($viewClassId)) {
  $viewClass = $classModel->getInfo($viewClassId);
  if (!is_array($viewClass) || empty($viewClass)) {
    $viewClass = null;
  } else {
    $currentPDT = !empty($viewClass["pdt_id"]) ? $userModel->getInfo($viewClass["pdt_id"]) : null;
    $currentLeader = !empty($viewClass["leader_id"]) ? $userModel->getInfo($viewClass["leader_id"]) : null;
    $currentViceLeader = !empty($viewClass["vice_leader_id"]) ? $userModel->getInfo($viewClass["vice_leader_id"]) : null;
    $students = $classModel->getUsers($viewClassId, ['lider', 'vice_lider', 'aluno']);
  }
} else {
  $filters = [];
  if (!empty($selectedGrade)) {
    $filters["grade"] = htmlspecialchars($selectedGrade, ENT_QUOTES, "UTF-8");
  }
  if ($searchTerm) {
    $filters["searchTerm"] = $searchTerm;
  }
  $count = $classModel->count($filters);
  $totalItems = $count['total'] ?? 0;
  $totalPages = ceil($totalItems / $itemsPerPage);
  $classes = $classModel->get($filters, $itemsPerPage, $offset);
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard - Turmas</title>
  <link rel="stylesheet" href="../../../public/css/output.css">
  <link href="../../../public/assets/fontawesome/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../public/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="min-h-full">
    <?php UI::renderNavbar($currentUser, "../../", "Dashboard", "blue", "altlogo.svg");
    UI::renderAlerts(true); ?>

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
                <a href="./turmas.php"><span
                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Turmas</span></a>
              </div>
            </li>
            <?php if (isset($viewClassId) && !empty($viewClass)) { ?>
              <li aria-current="page">
                <div class="flex items-center">
                  <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4" />
                  </svg>
                  <span
                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400"><?php echo htmlspecialchars($viewClass['name']); ?></span>
                </div>
              </li>
            <?php } ?>
          </ol>
        </nav>
      </div>
    </header>

    <?php if (!empty($viewClassId)) {
      if (empty($viewClass)) {
        echo '<main class="max-w-7xl mx-auto px-4 mt-5 flex justify-center items-center h-full"><div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-4 text-center"><h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200">Turma não encontrada</h2></div></main>';
      } else {
        include_once 'view/turma.php';
      }
    } else { ?>
      <main>
        <div class="max-w-7xl mx-auto px-4" style="margin-top: 15px;">
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
                  Série
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
                        <input id="filter-radio-all" type="radio" value="" name="filter-radio" onclick="filterGrade('')"
                          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="filter-radio-all"
                          class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Todos</label>
                      </div>
                    </li>
                    <?php
                    $grades = $conn->query("SELECT DISTINCT grade FROM classes")->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($grades as $grade) {
                      $safeGrade = htmlspecialchars($grade, ENT_QUOTES, "UTF-8");
                      echo '<li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                          <input id="filter-radio-' . $safeGrade . '" type="radio" name="filter-radio" value="' . $safeGrade . '"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            onchange="filterClasses(this.value)">
                          <label for="filter-radio-' . $safeGrade . '"
                            class="ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">' . $safeGrade . '</label>
                        </div>
                      </li>';
                    }
                    ?>
                  </ul>
                </div>
              </div>
              <div class="flex items-center gap-4">
                <div class="flex gap-2">
                  <button onclick="openclassAddModal()" id="classadd-open-modal-btn"
                    class="h-10 px-3 inline-flex items-center justify-center border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-graduation-cap"></i>
                  </button>
                  <button onclick="openclassBulkAddModal()" id="bulkclassadd-open-modal-btn"
                    class="h-10 px-3 inline-flex items-center justify-center border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="far fa-file-excel"></i>
                  </button>
                </div>
                <div class="relative w-72">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search w-4 h-4 text-gray-400"></i>
                  </div>
                  <input type="text" id="search-classes" value="<?php echo htmlspecialchars($searchTerm); ?>"
                    class="h-10 w-full pl-10 pr-4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Pesquisar por turma, série, PDT, líder ou vice-líder">
                </div>
              </div>
            </div>
            <div class="max-w-7xl mx-auto overflow-x-auto shadow-xl rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-200 dark:scrollbar-track-gray-700">
              <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Turma</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">PDT</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Líder</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vice-líder</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ação</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                  <?php
                  if (!empty($classes)) {
                    function renderUserCell(?array $user, ?int $userId, string $expectedRole, string $profileLinkPrefix = '../../perfil.php'): string
                    {
                      if (!empty($userId) && !empty($user['role']) && $user['role'] === $expectedRole) {
                        $userId = htmlspecialchars(Security::hide($user['id']), ENT_QUOTES, 'UTF-8');
                        $name = htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8');
                        $email = htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8');
                        $photo = htmlspecialchars($user['profile_photo'], ENT_QUOTES, 'UTF-8');
                        return <<<HTML
                          <td class="px-6 py-4">
                              <div class="flex items-center gap-3">
                                  <img class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-600"
                                       src="{$photo}" alt="Foto do usuário">
                                  <div class="flex-1 min-w-0">
                                      <div class="font-medium text-gray-900 dark:text-white truncate">
                                          <a href="{$profileLinkPrefix}?id={$userId}"
                                             class="hover:text-blue-600 dark:hover:text-blue-400">
                                              {$name}
                                          </a>
                                      </div>
                                      <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                          {$email}
                                      </div>
                                  </div>
                              </div>
                          </td>
                      HTML;
                      }
                      return '<td class="px-6 py-4 text-red-500 dark:text-red-400 italic">Não cadastrado</td>';
                    }
                    foreach ($classes as $row) { ?>
                      <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                        <td class="px-6 py-4">
                          <div class="flex items-center gap-3">
                            <div class="flex-1 min-w-0">
                              <div class="font-medium text-gray-900 dark:text-white truncate">
                                <a href="turmas.php?id=<?php echo htmlspecialchars(Security::hide($row["id"]), ENT_QUOTES, 'UTF-8'); ?>"
                                  class="hover:text-blue-600 dark:hover:text-blue-400">
                                  <?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                              </div>
                              <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo htmlspecialchars($row["grade"], ENT_QUOTES, 'UTF-8'); ?>º Ano
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                          <?php echo htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <?php
                        echo renderUserCell($row['pdt_info'] ?? null, $row['pdt_id'] ?? null, 'pdt');
                        echo renderUserCell($row['leader_info'] ?? null, $row['leader_id'] ?? null, 'lider');
                        echo renderUserCell($row['vice_leader_info'] ?? null, $row['vice_leader_id'] ?? null, 'vice_lider');
                        ?>
                        <td class="px-6 py-4">
                          <a href="./turmas.php?id=<?php echo htmlspecialchars(Security::hide($row["id"]), ENT_QUOTES, 'UTF-8'); ?>"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Editar
                          </a>
                        </td>
                      </tr>
                  <?php }
                  } else {
                    echo '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Nenhuma turma encontrada.</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php if ($totalPages > 1): ?>
              <div class="p-4 flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                  Mostrando <?php echo min(($offset + 1), $totalItems); ?> a <?php echo min($offset + count($classes), $totalItems); ?> de <?php echo $totalItems; ?> turmas
                </div>
                <nav aria-label="Paginação">
                  <ul class="inline-flex items-center space-x-1">
                    <li>
                      <a href="?page=<?php echo max(1, $page - 1); ?><?php echo $selectedGrade ? '&grade=' . urlencode($selectedGrade) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 <?php echo $page <= 1 ? 'cursor-not-allowed opacity-50' : ''; ?>">
                        <i class="fas fa-chevron-left mr-2"></i></a>
                    </li>
                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    if ($startPage > 1): ?>
                      <li>
                        <a href="?page=1<?php echo $selectedGrade ? '&grade=' . urlencode($selectedGrade) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                          class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700">1</a>
                      </li>
                      <?php if ($startPage > 2): ?>
                        <li><span class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">...</span></li>
                      <?php endif; ?>
                    <?php endif; ?>
                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                      <li>
                        <a href="?page=<?php echo $i; ?><?php echo $selectedGrade ? '&grade=' . urlencode($selectedGrade) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                          class="px-3 py-2 text-sm font-medium <?php echo $i === $page ? 'text-white bg-blue-600 border-blue-600' : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700'; ?> border rounded-lg">
                          <?php echo $i; ?>
                        </a>
                      </li>
                    <?php endfor; ?>
                    <?php if ($endPage < $totalPages): ?>
                      <?php if ($endPage < $totalPages - 1): ?>
                        <li><span class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">...</span></li>
                      <?php endif; ?>
                      <li>
                        <a href="?page=<?php echo $totalPages; ?><?php echo $selectedGrade ? '&grade=' . urlencode($selectedGrade) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                          class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700"><?php echo $totalPages; ?></a>
                      </li>
                    <?php endif; ?>
                    <li>
                      <a href="?page=<?php echo min($totalPages, $page + 1); ?><?php echo $selectedGrade ? '&grade=' . urlencode($selectedGrade) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 <?php echo $page >= $totalPages ? 'cursor-not-allowed opacity-50' : ''; ?>">
                        <i class="fas fa-chevron-right ml-2"></i></a>
                    </li>
                  </ul>
                </nav>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </main>
    <?php } ?>
  </div>

  <?php
  if (!isset($viewClassId)) {
    include_once "components/class/addModal.php";
    include_once "components/class/bulkAddModal.php";
    $scripts = [
      "../../../public/js/dashboard/class/addModalController.js",
      "../../../public/js/dashboard/class/bulkAddModalController.js",
      "../../../public/js/dashboard/class/searchBarController.js",
      "../../../public/js/dashboard/class/filterDropdown.js"
    ];
  } else {
    $scripts = ["view/js/turma.js"];
  }
  foreach ($scripts as $script) {
    echo '<script src="' . htmlspecialchars($script) . '"></script>';
  }
  ?>
</body>

</html>