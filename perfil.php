<?php
$editPanel = isset($_GET['editPanel']);
$isCurrentUser = false;
require_once 'methods/bootstrap.php';

$id = isset($_GET['id']) ? Utils::show($_GET['id']) : null;
$userId = $id ? intval($id) : $_SESSION['id'];

if ($userId == $_SESSION['id']) {
  $isCurrentUser = true;
}

$user = $userManager->getInfo($userId);

if ($editPanel) {
  $requiredRoles = $isCurrentUser ? [$user['role'], 'gestao'] : ['gestao'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Perfil de <?php echo htmlspecialchars($user['name']); ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="assets/images/logo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php UI::renderNavbar($currentUser, './',) ?>

  <div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-800">
      <div class="flex flex-col sm:flex-row items-center">
        <img alt="Foto de perfil de <?php echo htmlspecialchars($user['name']) ?>" class="rounded-full w-24 h-24"
          height="100" src="<?php echo htmlspecialchars($user['profile_photo']) ?>" width="100" />
        <div class="mt-4 sm:mt-0 sm:ml-4 text-center sm:text-left">
          <h1 class="text-2xl font-bold">
            <?php echo htmlspecialchars($user['name']) ?> -
            <span class="text-gray-600 dark:text-gray-400">
              Perfil
            </span>
          </h1>
          <p class="text-gray-600 dark:text-gray-400">
            <?php echo htmlspecialchars($user['bio']) ?>
          </p>
        </div>
      </div>
    </div>
    <div class="flex flex-col lg:flex-row mt-6">
      <div class="w-full lg:w-1/4">
        <div class="bg-white p-4 rounded-lg shadow-lg mb-6 dark:bg-gray-800">
          <h2 class="text-lg font-bold mb-2">
            Sobre
          </h2>
          <ul class="text-gray-600 dark:text-gray-400">
            <li class="flex justify-between">
              <span>
                Cargo:
              </span>
              <span>
                <?php echo htmlspecialchars(Utils::formatRoleName($user['role'], true)) ?>
              </span>
            </li>
            <?php if (isset($user['class_id']) && $user['class_id'] != 0) { ?>
              <li class="flex justify-between">
                <span>
                  Turma:
                </span>
                <span>
                  <?php
                  $class = $classManager->getInfo($user['class_id'], 'id', ['name']);
                  if ($currentUser['role'] == 'gestao') {
                    echo '<a href="./dashboard/pages/turmas.php?id=' . htmlspecialchars(Utils::hide($user['class_id'])) . '" class="font-medium text-green-600 dark:text-green-600">' . htmlspecialchars($class['name']) . '</a>';
                  } else {
                    echo htmlspecialchars($class['name']);
                  }
                  ?>
                </span>
              </li>
            <?php }
            ?>
            <li class="flex justify-between">
              <span>
                Entrou em:
              </span>
              <span>
                <?php echo Utils::formatDate($user['created_at']); ?>
              </span>
            </li>

            <?php if (isset($user['updated_at'])): ?>
              <li class="flex justify-between">
                <span>
                  Atualizado em:
                </span>
                <span>
                  <?php echo Utils::formatDate($user['updated_at']) ?>
                </span>
              </li>
            <?php endif; ?>

          </ul>
        </div>
      </div>
      <div class="w-full lg:w-3/4 lg:ml-6 mt-6 lg:mt-0">
        <div class="bg-white p-4 rounded-lg shadow-lg dark:bg-gray-800">
          <div class="border-b border-gray-200 mb-4 dark:border-gray-700">
            <ul class="flex">
              <li class="mr-6"><a
                  class="<?php echo $editPanel ? 'text-gray-600 dark:text-gray-400' : 'text-green-600 font-medium'; ?>"
                  href="perfil.php?id=<?php echo htmlspecialchars(Utils::hide($userId)); ?>">Atividade</a></li>
              <?php if ($isCurrentUser || $currentUser['role'] == 'gestao'): ?>
                <li class="mr-6"><a
                    class="<?php echo $editPanel ? 'text-green-600 font-medium' : 'text-gray-600 dark:text-gray-400'; ?>"
                    href="perfil.php?id=<?php echo htmlspecialchars(Utils::hide($userId) . '&editPanel'); ?>">Editar</a>
                </li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="space-y-4">
            <?php if ($editPanel) {
              if (in_array($currentUser["role"], ['gestao'])) {
                UI::renderUserEditionPanel($user, true);
              } elseif (!in_array($currentUser["role"], ['gestao']) && $isCurrentUser) {
                UI::renderUserEditionPanel($user);
              } else {
                echo '<div class="text-center text-2xl font-bold text-red-600 dark:text-red-400">Você não tem permissão para editar este perfil.</div>';
              }
            } else { ?>
              <div class="text-center text-2xl font-bold text-gray-600 dark:text-gray-400">
                *EM BREVE*
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php UI::renderFooter('./'); ?>
</body>

</html>