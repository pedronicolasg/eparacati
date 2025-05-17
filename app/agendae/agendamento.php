<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$scheduleId = $_GET['id'] ?? null;
$scheduleId = Security::show($scheduleId);
$currentSchedule = $scheduleModel->getInfo($scheduleId);
if ($currentSchedule) {
  $timeSlots = ScheduleModel::getTimeSlots();
  $scheduleEquipment = $currentSchedule['equipment_info'] ?? null;
  $scheduleUser = $currentSchedule['user_info'] ?? null;
  $scheduleClass = $currentSchedule['class_info'] ?? null;
} else {
  Navigation::redirect('index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?> h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê | Agendamento <?= htmlspecialchars($currentSchedule['id']) ?></title>
  <link rel="stylesheet" href="../../public/css/output.css">
  <link rel="shortcut icon" href="../../public/images/logo.svg" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&display=swap');

    body {
      font-family: "Exo", sans-serif;
    }
  </style>
</head>

<body class="flex flex-col min-h-screen bg-gradient-to-b bg-white dark:bg-gray-900 text-slate-800 dark:text-slate-100 font-sans antialiased">

  <?php
  UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg');
  UI::renderPopup(true);
  ?>

  <div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-slate-200/50 dark:border-slate-700/50">
      <div class="bg-gradient-to-r from-emerald-600 to-teal-500 py-6 px-8 relative">
        <a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'index.php') ?>" class="absolute left-6 top-1/2 -translate-y-1/2 flex items-center text-white/90 hover:text-white transition-colors group">
          <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
          Voltar
        </a>
        <h1 class="text-white text-3xl font-bold text-center tracking-tight">Detalhes do Agendamento</h1>
        <p class="text-emerald-100 text-sm text-center mt-2">ID: <?= $currentSchedule['id'] ?></p>
      </div>

      <div class="p-8 border-b border-slate-200/50 dark:border-slate-700/50">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-6 flex items-center">
          <i class="fas fa-microscope text-emerald-600 mr-3"></i>
          <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Equipamento</span>
        </h2>
        <div class="flex flex-col md:flex-row gap-8">
          <div class="w-full md:w-2/5">
            <div class="overflow-hidden rounded-xl shadow-md border border-slate-200/50 dark:border-slate-700/50">
              <img src="<?php echo !empty($scheduleEquipment['image']) ? $scheduleEquipment['image'] : 'https://placehold.co/900x600.png'; ?>" alt="<?= $scheduleEquipment['name']; ?>" class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105">
            </div>
          </div>
          <div class="w-full md:w-3/5">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-1"><?= $scheduleEquipment['name'] ?></h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">ID: <?= $scheduleEquipment['id'] ?></p>
            <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
              <?= htmlspecialchars($scheduleEquipment['description']) ?>
            </p>
          </div>
        </div>
      </div>

      <div class="p-8 border-b border-slate-200/50 dark:border-slate-700/50">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-6 flex items-center">
          <i class="fas fa-user text-emerald-600 mr-3"></i>
          <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Usuário</span>
        </h2>
        <div class="flex items-center gap-6">
          <div class="h-16 w-16 rounded-full overflow-hidden border-2 border-emerald-500/20 dark:border-emerald-400/20 shadow-md">
            <img src="<?= $scheduleUser['profile_photo']; ?>" alt="User Profile" class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
          </div>
          <div class="space-y-1">
            <h3 class="text-xl font-semibold text-slate-900 dark:text-white"><?= $scheduleUser['name'] ?></h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
              <i class="fas fa-building text-emerald-600 mr-2"></i><?= Format::roleName($scheduleUser['role']) ?>
            </p>
          </div>
        </div>
      </div>

      <div class="p-8 border-b border-slate-200/50 dark:border-slate-700/50">
        <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200 mb-6 flex items-center">
          <i class="fas fa-calendar-alt text-emerald-600 mr-3"></i>
          <span class="bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">Detalhes do Horário</span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="bg-slate-50/50 dark:bg-slate-700/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 transition-colors hover:bg-slate-100/50 dark:hover:bg-slate-600/50">
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center mb-2">
              <i class="far fa-calendar text-emerald-600 mr-2"></i>
              Data
            </p>
            <p class="text-lg font-medium text-slate-900 dark:text-white"><?= str_replace('-', '/', $currentSchedule['date']); ?></p>
          </div>
          <div class="bg-slate-50/50 dark:bg-slate-700/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 transition-colors hover:bg-slate-100/50 dark:hover:bg-slate-600/50">
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center mb-2">
              <i class="far fa-clock text-emerald-600 mr-2"></i>
              Horário
            </p>
            <?php
            $selectedTimeSlot = array_filter($timeSlots, function ($slot) use ($currentSchedule) {
              return $slot['id'] === $currentSchedule['schedule'];
            });
            $selectedTimeSlot = reset($selectedTimeSlot);
            ?>
            <p class="text-lg font-medium text-slate-900 dark:text-white">
              <?= htmlspecialchars($selectedTimeSlot['name'] . ' (' . $selectedTimeSlot['start'] . ' - ' . $selectedTimeSlot['end'] . ')') ?>
            </p>
          </div>
          <div class="bg-slate-50/50 dark:bg-slate-700/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 transition-colors hover:bg-slate-100/50 dark:hover:bg-slate-600/50">
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center mb-2">
              <i class="fas fa-users text-emerald-600 mr-2"></i>
              Turma
            </p>
            <p class="text-lg font-medium text-slate-900 dark:text-white"><?= $scheduleClass['name'] ?></p>
          </div>
          <div class="bg-slate-50/50 dark:bg-slate-700/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-700/50 transition-colors hover:bg-slate-100/50 dark:hover:bg-slate-600/50">
            <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center mb-2">
              <i class="fas fa-hashtag text-emerald-600 mr-2"></i>
              ID do Agendamento
            </p>
            <p class="text-lg font-medium text-slate-900 dark:text-white"><?= $currentSchedule['id'] ?></p>
          </div>
        </div>
      </div>

      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
          <i class="fas fa-sticky-note mr-2"></i>Observações
        </h2>
        <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 p-4 rounded">
          <p class="text-yellow-800 dark:text-yellow-200">
            <i class="fas fa-info-circle mr-2"></i>
            <?= htmlspecialchars($currentSchedule['note']); ?>
          </p>
        </div>
      </div>

      <div class="p-6 bg-gray-50 dark:bg-gray-700/50 flex justify-end gap-3">
        <a href="index.php" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
          <i class="fas fa-arrow-left mr-2"></i>Voltar
        </a>
        <a href="../src/controllers/schedule/cancel.php?id=<?= $currentSchedule['id'] ?>"
          onclick="return confirm('Tem certeza que deseja cancelar este agendamento?');" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" title="Deletar">
          <i class="fas fa-trash"></i>
        </a>
        <a href="../src/controllers/schedule/exportPDF.php?id=<?= $currentSchedule['id'] ?>" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          <i class="fas fa-print mr-2"></i>Imprimir
        </a>
      </div>
    </div>
  </div>

  <?php
  UI::renderFooter('../');
  ?>

</body>

</html>