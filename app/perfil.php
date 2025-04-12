<?php
$editPanel = isset($_GET['editPanel']);
$isCurrentUser = false;
require_once __DIR__ . '/src/bootstrap.php';

$id = isset($_GET['id']) ? Security::show($_GET['id']) : null;

$userId = $id ? intval($id) : $_SESSION['id'];

if ($userId == $_SESSION['id']) {
  $isCurrentUser = true;
}

$user = $userController->getInfo($userId);

if (empty($user)) {
  Navigation::alert('Usuário inesxistente.', $_SERVER['HTTP_REFERER']);
}

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
  <link rel="stylesheet" href="../public/assets/css/output.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../public/assets/images/logo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php
  UI::renderNavbar($currentUser, './',);
  UI::renderPopup(true);
  ?>

  <div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-1">
      <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-blue-500/10 dark:from-green-500/5 dark:to-blue-500/5"></div>
      <div class="relative p-8">
        <div class="flex flex-col md:flex-row items-center gap-8">
          <div class="relative group">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-blue-500 rounded-full opacity-50 group-hover:opacity-70 blur transition duration-300"></div>
            <img alt="Foto de perfil de <?php echo htmlspecialchars($user['name']) ?>" 
                class="relative w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-2xl transform transition duration-300 group-hover:scale-105"
                src="<?php echo htmlspecialchars($user['profile_photo']) ?>" />
          </div>
          <div class="flex-1 text-center md:text-left space-y-4">
            <div class="space-y-2">
              <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400">
                <?php echo htmlspecialchars($user['name']) ?>
              </h1>
              <p class="text-lg text-gray-600 dark:text-gray-300 font-medium italic">
                <?php echo htmlspecialchars($user['bio']) ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
      <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
          <div class="p-6">
            <h2 class="text-xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400">
              Informações
            </h2>
            <ul class="space-y-4 text-gray-600 dark:text-gray-300">
                <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="font-medium">Cargo</span>
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
                $roleClass = isset($roleColors[$user['role']]) ? $roleColors[$user['role']] : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                ?>
                <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo $roleClass; ?>">
                  <?php echo htmlspecialchars(Format::roleName($user['role'], true)) ?>
                </span>
                </li>

              <?php if (isset($user['class_id']) && $user['class_id'] != 0) { ?>
                <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                  <span class="font-medium">Turma</span>
                  <span class="text-right">
                    <?php
                    $class = $classController->getInfo($user['class_id'], 'id', ['name']);
                    if ($currentUser['role'] == 'gestao') {
                      echo '<a href="./dashboard/pages/turmas.php?id=' . htmlspecialchars(Security::hide($user['class_id'])) . '" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors">' . htmlspecialchars($class['name']) . '</a>';
                    } else {
                      echo '<span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">' . htmlspecialchars($class['name']) . '</span>';
                    }
                    ?>
                  </span>
                </li>
              <?php } ?>

              <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                <span class="font-medium">Entrou em</span>
                <span class="text-sm"><?php echo Format::date($user['created_at']); ?></span>
              </li>

              <?php if (isset($user['updated_at'])): ?>
                <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 transition-colors hover:bg-gray-100 dark:hover:bg-gray-700">
                  <span class="font-medium">Atualizado em</span>
                  <span class="text-sm"><?php echo Format::date($user['updated_at']) ?></span>
                </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="lg:col-span-3">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
          <div class="border-b border-gray-100 dark:border-gray-700">
            <nav class="flex px-6" aria-label="Tabs">
              <a href="perfil.php?id=<?php echo htmlspecialchars(Security::hide($userId)); ?>" 
                class="px-4 py-4 <?php echo !$editPanel ? 'text-green-600 dark:text-green-400 border-b-2 border-green-600 dark:border-green-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'; ?> transition-colors">
                Atividade
              </a>
              <?php if ($isCurrentUser || $currentUser['role'] == 'gestao'): ?>
                <a href="perfil.php?id=<?php echo htmlspecialchars(Security::hide($userId) . '&editPanel'); ?>" 
                  class="px-4 py-4 <?php echo $editPanel ? 'text-green-600 dark:text-green-400 border-b-2 border-green-600 dark:border-green-400 font-medium' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'; ?> transition-colors">
                  Editar
                </a>
              <?php endif; ?>
            </nav>
          </div>

          <div class="p-6">
            <?php if ($editPanel) {
              if (in_array($currentUser["role"], ['gestao'])) {
                UI::renderUserEditionPanel($user, true);
              } elseif (!in_array($currentUser["role"], ['gestao']) && $isCurrentUser) {
                UI::renderUserEditionPanel($user);
              } else {
                echo '<div class="flex items-center justify-center p-8">
                        <div class="text-center">
                          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                          </div>
                          <h3 class="text-xl font-bold text-red-600 dark:text-red-400 mb-2">Acesso Negado</h3>
                          <p class="text-gray-600 dark:text-gray-400">Você não tem permissão para editar este perfil.</p>
                        </div>
                      </div>';
              }
            } else { ?>
              <div class="flex items-center justify-center p-8">
                <div class="text-center">
                  <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700/50 mb-4">
                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                  </div>
                  <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Em Desenvolvimento</h3>
                  <p class="text-gray-600 dark:text-gray-400">Esta seção estará disponível em breve.</p>
                </div>
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