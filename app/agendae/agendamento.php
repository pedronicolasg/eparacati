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
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?> scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê | Agendamento <?= htmlspecialchars($currentSchedule['id']) ?></title>
  <link href="../../public/css/output.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="../../public/images/logo.svg" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">

  <?php
  UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg');
  UI::renderAlerts(true);
  ?>

  <main class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="mb-8">
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
          <a href="<?= htmlspecialchars($_SERVER['HTTP_REFERER'] ?? 'index.php') ?>"
            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 group">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            <span class="font-medium">Voltar</span>
          </a>
          <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
          <div>
            <h1 class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
              Detalhes do Agendamento
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
              <i class="fas fa-hashtag text-xs mr-1"></i>
              ID: <?= $currentSchedule['id'] ?>
            </p>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <a href="../src/controllers/schedule/exportPDF.php?id=<?= $currentSchedule['id'] ?>"
            target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-500/25 transition-all duration-200 font-medium">
            <i class="fas fa-print text-sm"></i>
            <span>Imprimir</span>
          </a>
          <a href="../src/controllers/schedule/cancel.php?id=<?= $currentSchedule['id'] ?>"
            onclick="return confirm('Tem certeza que deseja cancelar este agendamento?');"
            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-lg shadow-red-500/25 transition-all duration-200 font-medium">
            <i class="fas fa-trash text-sm"></i>
            <span>Cancelar</span>
          </a>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
      <div class="xl:col-span-2 space-y-8">

        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
          <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-xl">
                <i class="fas fa-microscope text-white text-xl"></i>
              </div>
              <h2 class="text-xl font-bold text-white">Equipamento</h2>
            </div>
          </div>

          <div class="p-8">
            <div class="flex flex-col lg:flex-row gap-8">
              <div class="lg:w-2/5">
                <div class="relative group overflow-hidden rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700">
                  <img src="<?php echo !empty($scheduleEquipment['image']) ? $scheduleEquipment['image'] : 'https://placehold.co/900x600.png'; ?>"
                    alt="<?= $scheduleEquipment['name']; ?>"
                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                  <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
              </div>

              <div class="lg:w-3/5 space-y-4">
                <div>
                  <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                    <?= $scheduleEquipment['name'] ?>
                  </h3>
                  <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-100 dark:bg-slate-700 rounded-full text-xs text-slate-600 dark:text-slate-400">
                    <i class="fas fa-hashtag text-xs"></i>
                    <span>ID: <?= $scheduleEquipment['id'] ?></span>
                  </div>
                </div>

                <div class="prose prose-slate dark:prose-invert max-w-none">
                  <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                    <?= htmlspecialchars($scheduleEquipment['description']) ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
          <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 p-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-xl">
                <i class="fas fa-user text-white text-xl"></i>
              </div>
              <h2 class="text-xl font-bold text-white">Responsável</h2>
            </div>
          </div>

          <div class="p-8">
            <div class="flex items-center gap-6">
              <div class="relative">
                <div class="h-20 w-20 rounded-2xl overflow-hidden border-4 border-emerald-500/20 dark:border-emerald-400/20 shadow-lg">
                  <img src="<?= $scheduleUser['profile_photo']; ?>"
                    alt="User Profile"
                    class="h-full w-full object-cover">
                </div>
              </div>

              <div class="space-y-2">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                  <?= $scheduleUser['name'] ?>
                </h3>
                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                  <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                    <i class="fas fa-building text-emerald-600 dark:text-emerald-400 text-xs"></i>
                  </div>
                  <span class="font-medium"><?= Format::roleName($scheduleUser['role']) ?></span>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="space-y-8">

        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
          <div class="bg-gradient-to-r from-orange-500 via-red-500 to-red-400 p-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-xl">
                <i class="fas fa-calendar-alt text-white text-xl"></i>
              </div>
              <h2 class="text-xl font-bold text-white">Horário</h2>
            </div>
          </div>

          <div class="p-6 space-y-4">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 dark:from-slate-700/50 dark:to-slate-600/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-600/50">
              <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                  <i class="far fa-calendar text-orange-600 dark:text-orange-400 text-sm"></i>
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Data</span>
              </div>
              <p class="text-lg font-bold text-slate-900 dark:text-white ml-11">
                <?= str_replace('-', '/', $currentSchedule['date']); ?>
              </p>
            </div>

            <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 dark:from-slate-700/50 dark:to-slate-600/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-600/50">
              <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                  <i class="far fa-clock text-blue-600 dark:text-blue-400 text-sm"></i>
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Período</span>
              </div>
              <?php
              $selectedTimeSlot = array_filter($timeSlots, function ($slot) use ($currentSchedule) {
                return $slot['id'] === $currentSchedule['schedule'];
              });
              $selectedTimeSlot = reset($selectedTimeSlot);
              ?>
              <div class="ml-11">
                <p class="text-lg font-bold text-slate-900 dark:text-white">
                  <?= htmlspecialchars($selectedTimeSlot['name']) ?>
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                  <?= htmlspecialchars($selectedTimeSlot['start'] . ' - ' . $selectedTimeSlot['end']) ?>
                </p>
              </div>
            </div>

            <div class="bg-gradient-to-r from-slate-50 to-slate-100/50 dark:from-slate-700/50 dark:to-slate-600/50 p-5 rounded-xl border border-slate-200/50 dark:border-slate-600/50">
              <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                  <i class="fas fa-users text-purple-600 dark:text-purple-400 text-sm"></i>
                </div>
                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Turma</span>
              </div>
              <p class="text-lg font-bold text-slate-900 dark:text-white ml-11">
                <?= $scheduleClass['name'] ?>
              </p>
            </div>
          </div>
        </div>

        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-2xl shadow-xl border border-slate-200/50 dark:border-slate-700/50 overflow-hidden">
          <div class="bg-gradient-to-r from-amber-500 via-yellow-500 to-orange-400 p-6">
            <div class="flex items-center gap-3">
              <div class="p-3 bg-white/20 rounded-xl">
                <i class="fas fa-sticky-note text-white text-xl"></i>
              </div>
              <h2 class="text-xl font-bold text-white">Observações</h2>
            </div>
          </div>

          <div class="p-6">
            <div class="bg-gradient-to-r from-yellow-50 via-amber-50 to-yellow-50 dark:from-yellow-900/20 dark:via-amber-900/20 dark:to-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-500 p-5 rounded-r-xl">
              <div class="flex items-start gap-3">
                <div class="p-2 bg-yellow-100 dark:bg-yellow-900/40 rounded-lg mt-0.5 flex-shrink-0">
                  <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400 text-sm"></i>
                </div>
                <p class="text-yellow-800 dark:text-yellow-200 leading-relaxed">
                  <?= htmlspecialchars($currentSchedule['note']); ?>
                </p>
              </div>
            </div>
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