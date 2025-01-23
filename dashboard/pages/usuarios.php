<?php
$requiredRoles = ["gestao"];
$basepath = "../../";
require_once "../../methods/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../assets/images/altlogo.svg" type="image/x-icon">
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
          (<?php echo Utils::formatRoleName($currentUser["role"]); ?>)</h1>

        <!-- Breadcrumb -->
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
        <?php if (isset($_SESSION['upload_success']) && $_SESSION['upload_success'] > 0): ?>
          <div
            class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z" />
            </svg>
            <span class="sr-only">Sucesso</span>
            <div>
              <span class="font-medium">Sucesso!</span>
              <?= htmlspecialchars($_SESSION['upload_success'], ENT_QUOTES, 'UTF-8') ?> usuários cadastrados com sucesso!
            </div>
          </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['upload_errors'])): ?>
          <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Erro</span>
            <div>
              <span class="font-medium">Erro ao cadastrar usuários:</span>
              <ul class="mt-1.5 list-disc list-inside">
                <?php foreach ($_SESSION['upload_errors'] as $error): ?>
                  <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        <?php endif; ?>

        <?php
        unset($_SESSION['upload_success'], $_SESSION['upload_errors']);
        ?>

        <?php if (isset($_SESSION['upload_error'])): ?>
          <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Erro</span>
            <div>
              <span class="font-medium">Erro:</span>
              <?= htmlspecialchars($_SESSION['upload_error'], ENT_QUOTES, 'UTF-8') ?>
            </div>
          </div>
          <?php unset($_SESSION['upload_error']); ?>
        <?php endif; ?>

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
                Filtrar por Cargo
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>

              <!-- Dropdown -->
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
                          class="ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300"><?= Utils::formatRoleName($safeRole) ?></label>
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
                <input type="text"
                  class="h-10 w-full pl-10 pr-4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                  placeholder="Pesquisar usuários">
              </div>
            </div>
          </div>

          <div class="max-w-7xl mx-auto overflow-x-auto">
            <table class="w-full text-sm text-left">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th class="px-6 py-3">Usuário</th>
                  <th class="px-6 py-3">ID</th>
                  <th class="px-6 py-3">Cargo</th>
                  <th class="px-6 py-3">Turma</th>
                  <th class="px-6 py-3">Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $selectedRole = isset($_GET["role"]) ? $_GET["role"] : null;

                $sql = "SELECT u.id, u.name, u.email, u.role, u.profile_photo, u.class_id, c.name as class_name
                    FROM users u
                    LEFT JOIN classes c ON u.class_id = c.id";

                if ($selectedRole) {
                  $sql .= " WHERE u.role = :role";
                }

                $stmt = $conn->prepare($sql);

                if ($selectedRole) {
                  $stmt->bindParam(":role", $selectedRole, PDO::PARAM_STR);
                }

                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr
                      class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                          <img class="w-10 h-10 rounded-full" src="<?= htmlspecialchars($row["profile_photo"]) ?>"
                            alt="Foto do usuário">
                          <div>
                            <div class="font-medium text-gray-900 dark:text-white">
                              <a href="../../perfil.php?id=<?= htmlspecialchars(Utils::hide($row["id"])) ?>">
                                <?= htmlspecialchars($row["name"]) ?>
                              </a>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                              <?= htmlspecialchars($row["email"]) ?>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        <?= htmlspecialchars($row["id"]) ?>
                      </td>
                      <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        <?= htmlspecialchars(Utils::formatRoleName($row["role"], true)) ?>
                      </td>
                      <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        <a href="<?= htmlspecialchars('turmas.php?id=' . Utils::hide($row['class_id'])); ?>"
                          class="text-green-600 hover:underline dark:text-green-500">
                          <?= htmlspecialchars($row["class_name"]) ?>
                        </a>
                      </td>
                      <td class="px-6 py-4">
                        <a href="../../perfil.php?id=<?= htmlspecialchars(Utils::hide($row["id"])) ?>&editPanel"
                          class="font-bold text-blue-600 hover:underline dark:text-blue-500">
                          Editar
                        </a>
                      </td>
                    </tr>
                  <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="5" class="px-6 py-4 text-center">Nenhum usuário encontrado.</td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>

  <?php include_once "includes/userAddModal.php"; ?>
  <?php include_once "includes/userBulkAddModal.php"; ?>

  <script src="../../assets/js/userAddModalController.js"></script>
  <script src="../../assets/js/userBulkAddModalController.js"></script>
  <script src="../../assets/js/userSearchBarController.js"></script>
  <script src="../../assets/js/userFilterDropdown.js"></script>
</body>

</html>