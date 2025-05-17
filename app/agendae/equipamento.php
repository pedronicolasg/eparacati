<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$currentEquipmentId = isset($_GET['id']) ? Security::show($_GET['id']) : null;
if (!empty($currentEquipmentId)) {
  $currentEquipment = $equipmentModel->getInfo($currentEquipmentId);
  $statusColor = $currentEquipment['status'] == 'disponivel' ? 'green' : 'red';
  $statusText = Format::statusName($currentEquipment['status']);
  $typeName = Format::typeName($currentEquipment['type']);
} else {
  $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
  Navigation::redirect($referer);
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?> h-full scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê | <?= htmlspecialchars($currentEquipment['name']) ?></title>
  <link rel="stylesheet" href="../../public/css/output.css">
  <link rel="shortcut icon" href="../../public/images/logo.svg" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&display=swap');

    body {
      font-family: "Exo", sans-serif;
    }

    img[src*='placehold.co'] {
      filter: grayscale(50%) brightness(95%);
    }

    .animate-slide-up {
      animation: slideUp 0.5s ease-out forwards;
    }

    @keyframes slideUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
  </style>
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 font-sans antialiased transition-colors duration-300">

  <?php
  UI::renderNavbar($currentUser, '../', '', 'teal', 'logo.svg');
  UI::renderPopup(true);
  ?>

  <main class="container mx-auto px-4 py-12 sm:py-16 lg:py-20">
    <header class="mb-10 flex flex-col sm:flex-row justify-between items-center gap-6 animate-slide-up">
      <div class="flex items-center gap-4">
        <i class="fas fa-info-circle text-4xl text-teal-600 dark:text-teal-400"></i>
        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Detalhes do Equipamento</h1>
      </div>
      <div class="flex items-center gap-3">
        <?php if ($currentUser['role'] == 'gestao') : ?>
          <a href="../dashboard/pages/equipamentos.php?id=<?php echo Security::hide($currentEquipment['id']); ?>"
            class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
            aria-label="Editar equipamento" title="Editar equipamento">
            <i class="fa-solid fa-pencil mr-2"></i> Editar
          </a>
        <?php endif; ?>
        <a href="index.php"
          class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
          aria-label="Voltar para a lista" title="Voltar para a lista">
          <i class="fa-solid fa-arrow-left mr-2"></i> Voltar
        </a>
      </div>
    </header>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-up">
      <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="relative bg-gray-100 dark:bg-gray-800/50 p-8 flex items-center justify-center">
          <img
            src="<?php echo !empty($currentEquipment['image']) ? htmlspecialchars($currentEquipment['image']) : 'https://placehold.co/600x450/e2e8f0/64748b?text=' . urlencode($typeName) . '&font=sans'; ?>"
            alt="Imagem de <?= htmlspecialchars($currentEquipment['name']) ?>"
            class="w-full h-64 lg:h-full object-contain rounded-xl shadow-md transition-transform duration-500 hover:scale-105"
            loading="lazy">
        </div>

        <div class="p-8 lg:p-10 flex flex-col gap-6">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white"><?php echo htmlspecialchars($currentEquipment['name']); ?></h2>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium text-white bg-<?php echo $statusColor; ?>-600 dark:bg-<?php echo $statusColor; ?>-700">
              <span class="w-2 h-2 mr-2 rounded-full bg-<?php echo $statusColor; ?>-500"></span>
              <?php echo htmlspecialchars($statusText); ?>
            </span>
          </div>

          <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-tag text-gray-400 dark:text-gray-500"></i>
              <span class="font-medium text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($typeName); ?></span>
            </div>
            <div class="flex items-center gap-2">
              <i class="fa-solid fa-hashtag text-gray-400 dark:text-gray-500"></i>
              <span class="font-mono bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">ID: <?php echo htmlspecialchars($currentEquipment['id']); ?></span>
            </div>
          </div>

          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3">Descrição</h3>
            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
              <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                <?php echo !empty($currentEquipment['description']) ? nl2br(htmlspecialchars($currentEquipment['description'])) : '<span class="italic text-gray-400 dark:text-gray-500">Nenhuma descrição fornecida.</span>'; ?>
              </p>
            </div>
          </div>

          <div class="text-xs text-gray-400 dark:text-gray-500 flex flex-col sm:flex-row gap-4">
            <div class="flex items-center gap-2">
              <i class="fa-regular fa-calendar-plus"></i>
              <span>Criado em: <?php echo htmlspecialchars(Format::date($currentEquipment['created_at'])); ?></span>
            </div>
            <?php if (!empty($currentEquipment['updated_at'])) : ?>
              <div class="flex items-center gap-2">
                <i class="fa-solid fa-arrows-rotate"></i>
                <span>Última atualização: <?php echo htmlspecialchars(Format::date($currentEquipment['updated_at'])); ?></span>
              </div>
            <?php endif; ?>
          </div>

          <div class="mt-6">
            <?php if ($currentEquipment['status'] === 'disponivel') : ?>
              <a href="agendar.php?id=<?php echo Security::hide($currentEquipment['id']); ?>"
                class="w-full flex items-center justify-center bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-teal-700 hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <i class="fa-regular fa-calendar-check mr-3"></i> Agendar Equipamento
              </a>
            <?php else : ?>
              <button disabled
                class="w-full flex items-center justify-center bg-gray-400 dark:bg-gray-600 text-gray-100 dark:text-gray-300 py-3 px-6 rounded-lg font-semibold text-lg cursor-not-allowed opacity-70">
                <i class="fas fa-ban mr-3"></i> Indisponível para Agendamento
              </button>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php
  UI::renderFooter('../');
  ?>

</body>

</html>