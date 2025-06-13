<?php
$editPanel = isset($_GET['editPanel']);
$isCurrentUser = false;
require_once __DIR__ . '/src/bootstrap.php';

$id = isset($_GET['id']) ? Security::show($_GET['id']) : null;
$userId = $id ? intval($id) : $_SESSION['id'];

if ($userId == $_SESSION['id']) {
  $isCurrentUser = true;
}

$user = $userModel->getInfo($userId);

if (empty($user)) {
  Navigation::alert(
    'Usuário inexistente.',
    'O Usuário requisitado não existe',
    'error',
    $_SERVER['HTTP_REFERER']
  );
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
  <link rel="stylesheet" href="../public/css/output.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../public/images/logo.svg" type="image/x-icon">
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
  <?php
  UI::renderNavbar($currentUser, './');
  UI::renderAlerts(true);
  ?>

  <div class="container mx-auto px-4 py-12 max-w-6xl">
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
      <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-blue-500/10 dark:from-green-500/5 dark:to-blue-500/5"></div>
      <div class="relative p-6 md:p-8">
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-8">
          <div class="relative group flex-shrink-0">
            <div class="absolute -inset-1 bg-gradient-to-r from-green-500 to-blue-500 rounded-full opacity-30 group-hover:opacity-50 blur-md transition duration-300"></div>
            <img alt="Foto de perfil de <?php echo htmlspecialchars($user['name']); ?>"
              class="relative w-24 h-24 md:w-32 md:h-32 rounded-full object-cover border-3 border-white dark:border-gray-700 shadow-lg group-hover:scale-105 transition-transform duration-300"
              src="<?php echo htmlspecialchars($user['profile_photo']); ?>" />
          </div>
          <div class="flex-1 text-center md:text-left space-y-3">
            <h1 class="text-2xl md:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400">
              <?php echo htmlspecialchars($user['name']); ?>
            </h1>
            <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 italic">
              <?php echo htmlspecialchars($user['bio']); ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 space-y-6 transition-all duration-300 hover:shadow-xl">
          <h2 class="text-xl font-semibold bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-blue-600 dark:from-green-400 dark:to-blue-400">
            Informações
          </h2>
          <ul class="space-y-4 text-gray-600 dark:text-gray-300">
            <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
              <span class="font-medium flex items-center gap-2">
                <i class="fas fa-user-tag"></i> Cargo
              </span>
              <?php
              $roleColors = [
                'aluno' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                'lider' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                'vice_lider' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/50 dark:text-teal-300',
                'gremio' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
                'professor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                'pdt' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
                'funcionario' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/50 dark:text-pink-300',
                'gestao' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300'
              ];
              $roleClass = isset($roleColors[$user['role']]) ? $roleColors[$user['role']] : 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300';
              ?>
              <span class="px-3 py-1 rounded-full text-sm font-semibold <?php echo $roleClass; ?>">
                <?php echo htmlspecialchars(Format::roleName($user['role'], true)); ?>
              </span>
            </li>

            <?php if (isset($user['class_id']) && $user['class_id'] != 0): ?>
              <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                <span class="font-medium flex items-center gap-2">
                  <i class="fas fa-chalkboard"></i> Turma
                </span>
                <span class="text-right">
                  <?php
                  $class = $classModel->getInfo($user['class_id'], 'id', ['name']);
                  if ($currentUser['role'] == 'gestao') {
                    echo '<a href="./dashboard/pages/turmas.php?id=' . htmlspecialchars(Security::hide($user['class_id'])) . '" class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors">' . htmlspecialchars($class['name']) . '</a>';
                  } else {
                    echo '<span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">' . htmlspecialchars($class['name']) . '</span>';
                  }
                  ?>
                </span>
              </li>
            <?php endif; ?>

            <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
              <span class="font-medium flex items-center gap-2">
                <i class="fas fa-calendar-plus"></i> Entrou em
              </span>
              <span class="text-sm"><?php echo Format::date($user['created_at']); ?></span>
            </li>

            <?php if (isset($user['updated_at'])): ?>
              <li class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                <span class="font-medium flex items-center gap-2">
                  <i class="fas fa-calendar-check"></i> Atualizado em
                </span>
                <span class="text-sm"><?php echo Format::date($user['updated_at']); ?></span>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
          <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex px-6" aria-label="Tabs">
              <a href="perfil.php?id=<?php echo htmlspecialchars(Security::hide($userId)); ?>"
                class="px-4 py-3 text-sm <?php echo !$editPanel ? 'font-bold text-green-600 dark:text-green-400 border-b-2 border-green-600 dark:border-green-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'; ?> transition-colors duration-200">
                Atividade
              </a>
              <?php if ($isCurrentUser || $currentUser['role'] == 'gestao'): ?>
                <a href="perfil.php?id=<?php echo htmlspecialchars(Security::hide($userId) . '&editPanel'); ?>"
                  class="px-4 py-3 text-sm <?php echo $editPanel ? 'font-bold text-green-600 dark:text-green-400 border-b-2 border-green-600 dark:border-green-400' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'; ?> transition-colors duration-200">
                  Editar
                </a>
              <?php endif; ?>
            </nav>
          </div>

          <div class="p-6">
            <?php if ($editPanel) {
              if (in_array($currentUser['role'], ['gestao'])) {
                $ui->renderUserEditionPanel($user, true);
              } elseif (!in_array($currentUser['role'], ['gestao']) && $isCurrentUser) {
                $ui->renderUserEditionPanel($user);
              } else { ?>
                <div class="flex items-center justify-center p-8">
                  <div class="text-center space-y-4">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30">
                      <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-red-600 dark:text-red-400">Acesso Negado</h3>
                    <p class="text-gray-600 dark:text-gray-400">Você não tem permissão para editar este perfil.</p>
                  </div>
                </div>
              <?php }
            } else { ?>
              <div class="flex items-center justify-center p-8">
                <div class="text-center space-y-4">
                  <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700/50">
                    <i class="fas fa-tools text-2xl text-gray-600 dark:text-gray-400"></i>
                  </div>
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Em Desenvolvimento</h3>
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
  <script>
    function handlePhoneNumber(event) {
      let input = event.target;
      input.value = input.value.replace(/\D/g, '');
    }

    function formatPhoneNumber(event) {
      let input = event.target;
      let value = input.value.replace(/\D/g, '');

      if (value.length > 11) {
        value = value.substring(0, 11);
      }

      let formattedValue = '';
      if (value.length > 0) {
        if (value.length <= 2) {
          formattedValue = '(' + value;
        } else {
          formattedValue = '(' + value.substring(0, 2) + ')';
          if (value.length > 2) {
            formattedValue += ' ' + value.substring(2, 7);
            if (value.length > 7) {
              formattedValue += '-' + value.substring(7);
            }
          }
        }
      }

      input.value = formattedValue;
    }
  </script>
</body>

</html>