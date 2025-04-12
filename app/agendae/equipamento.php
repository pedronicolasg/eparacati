<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$currentEquipmentId = isset($_GET['id']) ? Security::show($_GET['id']) : null;
if (!empty($currentEquipmentId)) {
  $currentEquipment = $equipmentController->getInfo($currentEquipmentId);
  if ($currentEquipment['status'] == 'disponivel') {
    $color = 'green';
  } else {
    $color = 'red';
  }
} else {
  Navigation::redirect($_SERVER['HTTP_REFERER']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê</title>
  <link rel="stylesheet" href="../../public/assets/css/output.css">
  <link rel="shortcut icon" href="../../public/assets/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body
  class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-white min-h-screen">

  <?php
  UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg');
  UI::renderPopup(true);
  ?>

  <div class="container mx-auto px-4 py-8 max-w-5xl">
    <header class="flex justify-between items-center mb-6">
      <div class="flex items-center">
        <i class="fa-solid fa-bolt text-cyan-600 dark:text-cyan-400 text-2xl"></i>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white ml-2">Detalhes do Equipamento</h1>
      </div>

      <div class="flex space-x-2">
        <?php if ($currentUser['role'] == 'gestao') { ?>
          <button
            onclick="window.location.href='../dashboard/pages/equipamentos.php?id=<?php echo Security::hide($currentEquipment['id']); ?>'"
            class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 dark:focus:ring-offset-gray-800"
            aria-label="Editar equipamento">
            <i class="fa-solid fa-pencil text-cyan-600 dark:text-cyan-400 text-lg"></i>
          </button>
        <?php } ?>
        <button
          onclick="window.location.href='index.php'"
          class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800"
          aria-label="Voltar">
          <i class="fa-solid fa-arrow-left text-green-600 dark:text-green-400 text-lg"></i>
        </button>
      </div>
    </header>

    <main class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
      <div class="bg-gradient-to-r from-cyan-500 to-blue-500 dark:from-cyan-600 dark:to-blue-600 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 text-white backdrop-blur-sm animate-pulse-slow">
            <span class="w-2 h-2 mr-2 rounded-full bg-<?= $color ?>-600"></span>
            <?= Format::statusName($currentEquipment['status']) ?>
          </span>
          <span class="ml-4 text-white text-sm font-medium">ID: <?= $currentEquipment['id'] ?></span>
        </div>
        <div>
          <span class="px-3 py-1 text-xs uppercase tracking-wider font-semibold rounded-full bg-white/20 text-white backdrop-blur-sm">
            <?= Format::typeName($currentEquipment['type']) ?>
          </span>
        </div>
      </div>

      <div class="md:flex">
        <div class="md:w-2/5 p-4 flex items-center justify-center bg-gray-100 dark:bg-gray-700/30">
          <div class="relative overflow-hidden rounded-lg group">
            <img
              src="<?php echo $currentEquipment['image'] ?? 'https://placehold.co/900x600.png?text=' . Format::typeName($currentEquipment['type']) . '&font=poppings' ?>"
              alt="<?= $currentEquipment['name'] ?>"
              class="w-full h-64 object-contain transition-transform duration-500 transform group-hover:scale-105">
          </div>
        </div>

        <div class="md:w-3/5 p-6">
          <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2"><?= $currentEquipment['name'] ?></h2>
            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-4">
              <div class="flex items-center">
                <i class="fa-regular fa-calendar mr-2 text-gray-400 dark:text-gray-500"></i>
                <span>Criado em: <?= $currentEquipment['created_at'] ?></span>
              </div>
              <div class="flex items-center">
                <i class="fa-solid fa-arrows-rotate mr-2 text-gray-400 dark:text-gray-500"></i>
                <span>Atualizado em: <?= $currentEquipment['updated_at'] ?></span>
              </div>
            </div>
          </div>

          <div class="mb-6">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Descrição</h3>
            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg">
              <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                <?= $currentEquipment['description'] ?>
              </p>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg transition-transform duration-300 transform hover:-translate-y-1 hover:shadow-md">
              <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status</h3>
              <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full bg-<?= $color ?>-500 mr-2"></span>
                <span class="text-<?= $color ?>-600 dark:text-<?= $color ?>-400 font-medium"><?= Format::statusName($currentEquipment['status']) ?></span>
              </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg transition-transform duration-300 transform hover:-translate-y-1 hover:shadow-md">
              <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Tipo</h3>
              <span class="font-medium text-gray-800 dark:text-gray-200"><?= Format::typeName($currentEquipment['type']) ?></span>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700/30 p-4 rounded-lg transition-transform duration-300 transform hover:-translate-y-1 hover:shadow-md">
              <h3 class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">ID</h3>
              <span class="font-medium text-gray-800 dark:text-gray-200"><?= $currentEquipment['id'] ?></span>
            </div>
          </div>

          <?php if ($currentEquipment['status'] === 'disponivel') { ?>
            <button onclick="window.location.href='agendar.php?id=<?= Security::hide($currentEquipment['id']); ?>'" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800 flex items-center justify-center">
              <i class="fa-regular fa-calendar-check mr-2"></i>
              Agendar
            </button>
          <?php } else { ?>
            <button disabled="" class="w-full bg-gray-400 dark:bg-gray-600 text-white py-3 px-4 rounded-lg font-medium transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800 flex items-center justify-center cursor-not-allowed">
              <i class="fas fa-ban mr-2"></i>
              Indisponível
            </button>
          <?php } ?>
        </div>
      </div>
    </main>
  </div>

  <?php UI::renderFooter('../'); ?>

</body>

</html>