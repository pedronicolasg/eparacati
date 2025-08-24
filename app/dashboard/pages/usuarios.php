<?php
$requiredRoles = ["gestao"];
require_once dirname(dirname(__DIR__)) . '/src/bootstrap.php';

$itemsPerPage = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedRole = isset($_GET["role"]) ? $_GET["role"] : null;

$sql = "SELECT u.id, u.name, u.email, u.phone, u.role, u.profile_photo, u.class_id, c.name as class_name
        FROM users u
        LEFT JOIN classes c ON u.class_id = c.id
        WHERE 1=1";

$params = [];
if ($selectedRole) {
  $sql .= " AND u.role = :role";
  $params[':role'] = $selectedRole;
}
if ($searchTerm) {
  $sql .= " AND (u.name LIKE :search OR u.email LIKE :search OR u.phone LIKE :search OR c.name LIKE :search)";
  $params[':search'] = "%$searchTerm%";
}

$countSql = str_replace('SELECT u.id, u.name, u.email, u.phone, u.role, u.profile_photo, u.class_id, c.name as class_name', 'SELECT COUNT(*)', $sql);
$stmt = $conn->prepare($countSql);
foreach ($params as $key => $value) {
  $stmt->bindValue($key, $value);
}
$stmt->execute();
$totalItems = $stmt->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

$sql .= " ORDER BY u.name ASC LIMIT :limit OFFSET :offset";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
  $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard - Usuários</title>
  <link rel="stylesheet" href="../../../public/css/output.css">
  <link href="../../../public/assets/fontawesome/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../../public/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="min-h-full">
    <?php
    UI::renderNavbar($currentUser, "../../", "Dashboard", "blue", "altlogo.svg");
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
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Usuários</span>
              </div>
            </li>
          </ol>
        </nav>
      </div>
    </header>

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
                Cargo
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
                      <input id="filter-radio-all" type="radio" value="" name="filter-radio" onclick="filterRole('')"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="filter-radio-all"
                        class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Todos</label>
                    </div>
                  </li>
                  <?php
                  $roles = $conn
                    ->query("SELECT DISTINCT role FROM users")
                    ->fetchAll(PDO::FETCH_COLUMN);
                  foreach ($roles as $role) {
                    $safeRole = htmlspecialchars($role, ENT_QUOTES, "UTF-8");
                  ?>
                    <li>
                      <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                        <input id="filter-radio-<?= $safeRole ?>" type="radio" name="filter-radio"
                          value="<?= $safeRole ?>"
                          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                          onchange="filterUsers(this.value)">
                        <label for="filter-radio-<?= $safeRole ?>"
                          class="ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?= Format::roleName($safeRole) ?></label>
                      </div>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>

            <div class="flex items-center gap-4">
              <div class="flex gap-2">
                <button onclick="openUserAddModal()" id="useradd-open-modal-btn"
                  class="h-10 px-3 inline-flex items-center justify-center border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  <i class="fas fa-user-plus"></i>
                </button>

                <button onclick="openUserBulkAddModal()" id="bulkuseradd-open-modal-btn"
                  class="h-10 px-3 inline-flex items-center justify-center border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  <i class="far fa-file-excel"></i>
                </button>
              </div>

              <div class="relative w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-search w-4 h-4 text-gray-400"></i>
                </div>
                <input type="text" id="search-users" value="<?php echo htmlspecialchars($searchTerm); ?>"
                  class="h-10 w-full pl-10 pr-4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                  placeholder="Pesquisar por nome, email, telefone ou turma">
              </div>
            </div>
          </div>

          <div class="max-w-7xl mx-auto overflow-x-auto shadow-xl rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-200 dark:scrollbar-track-gray-700">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuário</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cargo</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Turma</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ação</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800">
                <?php if (count($users) > 0): ?>
                  <?php foreach ($users as $row): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center space-x-4">
                          <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200 dark:ring-gray-700"
                            src="<?= htmlspecialchars($row["profile_photo"]) ?>"
                            alt="Foto do usuário">
                          <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition">
                              <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>">
                                <?= htmlspecialchars($row["name"]) ?>
                              </a>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-2">
                              <span class="flex items-center">
                                <i class="fas fa-envelope w-4 h-4 mr-1.5 text-red-400 dark:text-red-500"></i>
                                <?= htmlspecialchars($row["email"]) ?>
                              </span>
                            </div>
                            <?php if (!empty($row["phone"])): ?>
                              <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center space-x-2 mt-1">
                                <span class="flex items-center">
                                  <i class="fas fa-phone w-4 h-4 mr-1.5 text-blue-400 dark:text-blue-500"></i>
                                  <?= Format::phoneNumber($row["phone"]) ?>
                                </span>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">
                        <?= htmlspecialchars($row["id"]) ?>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $roleColors = [
                          'aluno' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                          'lider' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                          'vice_lider' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200',
                          'gremio' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                          'professor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                          'pdt' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                          'funcionario' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
                          'gestao' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                        ];
                        $colorClass = $roleColors[$row["role"]] ?? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                        ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $colorClass ?>">
                          <?= htmlspecialchars(Format::roleName($row["role"], true)) ?>
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="<?= htmlspecialchars('turmas.php?id=' . Security::hide($row['class_id'])); ?>"
                          class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 hover:underline transition">
                          <?= htmlspecialchars($row["class_name"]) ?>
                        </a>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>&editPanel"
                          class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                          <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                      <div class="flex flex-col items-center justify-center py-6">
                        <i class="fas fa-user-slash text-4xl mb-3 text-gray-400 dark:text-gray-600"></i>
                        Nenhum usuário encontrado.
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <?php if ($totalPages > 1): ?>
            <div class="p-4 flex items-center justify-between">
              <div class="text-sm text-gray-600 dark:text-gray-400">
                Mostrando <?php echo min(($offset + 1), $totalItems); ?> a <?php echo min($offset + count($users), $totalItems); ?> de <?php echo $totalItems; ?> usuários
              </div>
              <nav aria-label="Paginação">
                <ul class="inline-flex items-center space-x-1">
                  <li>
                    <a href="?page=<?php echo max(1, $page - 1); ?><?php echo $selectedRole ? '&role=' . urlencode($selectedRole) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                      class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 <?php echo $page <= 1 ? 'cursor-not-allowed opacity-50' : ''; ?>">
                      <i class="fas fa-chevron-left mr-2"></i></a>
                  </li>
                  <?php
                  $startPage = max(1, $page - 2);
                  $endPage = min($totalPages, $page + 2);
                  if ($startPage > 1): ?>
                    <li>
                      <a href="?page=1<?php echo $selectedRole ? '&role=' . urlencode($selectedRole) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                      <li><span class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">...</span></li>
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li>
                      <a href="?page=<?php echo $i; ?><?php echo $selectedRole ? '&role=' . urlencode($selectedRole) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
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
                      <a href="?page=<?php echo $totalPages; ?><?php echo $selectedRole ? '&role=' . urlencode($selectedRole) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                        class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700"><?php echo $totalPages; ?></a>
                    </li>
                  <?php endif; ?>
                  <li>
                    <a href="?page=<?php echo min($totalPages, $page + 1); ?><?php echo $selectedRole ? '&role=' . urlencode($selectedRole) : ''; ?><?php echo $searchTerm ? '&search=' . urlencode($searchTerm) : ''; ?>"
                      class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 <?php echo $page >= $totalPages ? 'cursor-not-allowed opacity-50' : ''; ?>"><i class="fas fa-chevron-right ml-2"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>


  <?php
  include_once "components/user/addModal.php";
  include_once "components/user/bulkAddModal.php";
  ?>

  <script src="../../../public/js/dashboard/user/addModalController.js"></script>
  <script src="../../../public/js/dashboard/user/bulkAddModalController.js"></script>
  <script src="../../../public/js/dashboard/user/searchBarController.js"></script>
  <script src="../../../public/js/dashboard/user/filterDropdown.js"></script>
</body>

</html>