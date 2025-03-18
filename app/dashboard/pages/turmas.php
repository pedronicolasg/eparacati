<?php
$requiredRoles = ["gestao"];
$basepath = "../../";
require_once dirname(dirname(__DIR__)) . '/src/bootstrap.php';

$viewClassId = isset($_GET['id']) ? Security::show($_GET['id']) : null;
if (isset($viewClassId)) {
  $viewClass = $classController->getInfo($viewClassId);
  $currentPDT = $userController->getInfo($viewClass["pdt_id"]);
  $currentLeader = $userController->getInfo($viewClass["leader_id"]);
  $currentViceLeader = $userController->getInfo($viewClass["vice_leader_id"]);

  $students = $classController->getUsers($viewClassId, ['lider', 'vice_lider', 'aluno']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard - Turmas</title>
  <link rel="stylesheet" href="../../../public/assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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
                <a href="./turmas.php"><span
                    class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">Turmas</span></a>
              </div>
            </li>

            <?php if (isset($viewClassId)) {
            ?>
              <li aria-current="page">
                <div class="flex items-center">
                  <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4" />
                  </svg>
                  <span
                    class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400"><?php echo $viewClass['name']; ?></span>
                </div>
              </li>
            <?php
            } ?>
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
                <?= htmlspecialchars($_SESSION['upload_success'], ENT_QUOTES, 'UTF-8') ?> turmas cadastradas com sucesso!
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
                <span class="font-medium">Erro ao cadastrar turmas:</span>
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
                    $grades = $conn
                      ->query("SELECT DISTINCT grade FROM classes")
                      ->fetchAll(PDO::FETCH_COLUMN);
                    foreach ($grades as $grade) {
                      $safeGrade = htmlspecialchars($grade, ENT_QUOTES, "UTF-8");
                      echo '
                  <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                      <input id="filter-radio-' .
                        $safeGrade .
                        '" type="radio" name="filter-radio" value="' .
                        $safeGrade .
                        '"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        onchange="filterClasses(this.value)">
                      <label for="filter-radio-' .
                        $safeGrade .
                        '"
                        class="ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">' .
                        $safeGrade .
                        '</label>
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
                  <input type="text"
                    class="h-10 w-full pl-10 pr-4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Pesquisar turmas">
                </div>
              </div>
            </div>

            <div class="max-w-7xl mx-auto overflow-x-auto">
              <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th class="px-6 py-3">Turma</th>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">PDT</th>
                    <th class="px-6 py-3">Líder</th>
                    <th class="px-6 py-3">Vice-líder</th>
                    <th class="px-6 py-3">Ação</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $selectedGrade = $_GET["grade"] ?? null;

                  $sql = "SELECT id, name, grade, pdt_id, leader_id, vice_leader_id FROM classes";

                  if ($selectedGrade) {
                    $sql .= " WHERE grade = :grade";
                  }

                  $stmt = $conn->prepare($sql);

                  if ($selectedGrade) {
                    $stmt->bindParam(":grade", $selectedGrade, PDO::PARAM_STR);
                  }

                  $stmt->execute();

                  if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                      <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                        <td class="px-6 py-4">
                          <div class="flex items-center gap-3">
                            <div>
                              <div class="font-medium text-gray-900 dark:text-white">
                                <a href="turmas.php?id=<?php echo htmlspecialchars(Security::hide($row["id"])); ?>">
                                  <?php echo htmlspecialchars($row["name"]); ?>
                                </a>
                              </div>
                              <div class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo htmlspecialchars($row["grade"]); ?>º Ano
                              </div>
                            </div>
                          </div>
                        </td>

                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                          <?php echo htmlspecialchars($row["id"]); ?>
                        </td>

                        <?php $pdt = $userController->getInfo($row["pdt_id"]);
                        if (isset($row['pdt_id']) && isset($pdt['role']) && $pdt['role'] == 'pdt') {
                        ?>
                          <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                              <img class="w-10 h-10 rounded-full" src="<?php echo htmlspecialchars($pdt['profile_photo']); ?>"
                                alt="Foto do usuário">
                              <div>
                                <div class="font-medium text-gray-900 dark:text-white">
                                  <a href="../../perfil.php?id=<?php echo htmlspecialchars(Security::hide($pdt["id"])); ?>">
                                    <?php echo htmlspecialchars($pdt["name"]); ?>
                                  </a>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                  <?php echo htmlspecialchars($pdt["email"]); ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        <?php } else {
                          if (isset($row['pdt_id']) && isset($pdt['role'])) {
                            $classController->handleUserRoleChange($row['pdt_id'], $pdt['role']);
                          }
                          echo '<td class="px-6 py-4 text-red-500 dark:text-red-400">Não cadastrado</td>';
                        } ?>

                        <?php $leader = $userController->getInfo($row["leader_id"]);
                        if (isset($row['leader_id']) && isset($leader['role']) && $leader['role'] == 'lider') {
                        ?>
                          <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                              <img class="w-10 h-10 rounded-full" src="<?php echo $leader['profile_photo']; ?>"
                                alt="Foto do usuário">
                              <div>
                                <div class="font-medium text-gray-900 dark:text-white">
                                  <a href="../../perfil.php?id=<?php echo htmlspecialchars(Security::hide($leader["id"])); ?>">
                                    <?php echo htmlspecialchars($leader["name"]); ?>
                                  </a>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                  <?php echo htmlspecialchars($leader["email"]); ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        <?php } else {
                          if (isset($row['leader_id']) && isset($leader['role'])) {
                            $classController->handleUserRoleChange($row['leader_id'], $leader['role']);
                          }
                          echo '<td class="px-6 py-4 text-red-500 dark:text-red-400">Não cadastrado</td>';
                        } ?>

                        <?php $viceLeader = $userController->getInfo($row["vice_leader_id"]);
                        if (isset($row['vice_leader_id']) && isset($viceLeader['role']) && $viceLeader['role'] == 'vice_lider') {
                        ?>
                          <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                              <img class="w-10 h-10 rounded-full"
                                src="<?php echo htmlspecialchars($viceLeader['profile_photo']); ?>" alt="Foto do usuário">
                              <div>
                                <div class="font-medium text-gray-900 dark:text-white">
                                  <a href="../../perfil.php?id=<?php echo htmlspecialchars(Security::hide($viceLeader["id"])); ?>">
                                    <?php echo htmlspecialchars($viceLeader["name"]); ?>
                                  </a>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                  <?php echo htmlspecialchars($viceLeader["email"]); ?>
                                </div>
                              </div>
                            </div>
                          </td>
                        <?php } else {
                          if (isset($row['vice_leader_id']) && isset($viceLeader['role'])) {
                            $classController->handleUserRoleChange($row['vice_leader_id'], $viceLeader['role']);
                          }
                          echo '<td class="px-6 py-4 text-red-500 dark:text-red-400">Não cadastrado</td>';
                        } ?>

                        <td class="px-6 py-4">
                          <a href="./turmas.php?id=<?php echo htmlspecialchars(Security::hide($row["id"])); ?>"
                            class="font-bold text-blue-600 hover:underline dark:text-blue-500">
                            Editar
                          </a>
                        </td>
                      </tr>
                  <?php }
                  } else {
                    echo '<tr>
                      <td colspan="6" class="px-6 py-4 text-center">Nenhuma turma encontrada.</td>
                    </tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
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
      "../../../public/assets/js/dashboard/class/addModalController.js",
      "../../../public/assets/js/dashboard/class/bulkAddModalController.js",
      "../../../public/assets/js/dashboard/class/searchBarController.js",
      "../../../public/assets/js/dashboard/class/filterDropdown.js"
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