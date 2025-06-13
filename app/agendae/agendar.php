<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$equipmentId = isset($_GET['id']) ? Security::show((string)$_GET['id']) : null;
$type = isset($_GET['type']) ? Security::sanitizeInput((string)$_GET['type']) : null;
$month = isset($_GET['month']) ? (int)$_GET['month'] : null;
$year = isset($_GET['year']) ? (int)$_GET['year'] : null;
$day = isset($_GET['day']) ? (int)$_GET['day'] : null;

$currentDate = new DateTime();
$currentYear = (int)$currentDate->format('Y');
$currentMonth = (int)$currentDate->format('n');
$currentDay = (int)$currentDate->format('j');
$currentDateMidnight = new DateTime($currentDate->format('Y-m-d'));

$month = $month ?: $currentMonth;
$year = $year ?: $currentYear;
if ($year < $currentYear || ($year === $currentYear && $month < $currentMonth)) {
  $month = $currentMonth;
  $year = $currentYear;
}

$firstDayOfMonth = new DateTime("$year-$month-01");
$lastDayOfMonth = new DateTime($firstDayOfMonth->format('Y-m-t'));
$daysInMonth = (int)$lastDayOfMonth->format('j');
$firstDayOfWeek = (int)$firstDayOfMonth->format('w');

$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) {
  $prevMonth = 12;
  $prevYear--;
}
$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) {
  $nextMonth = 1;
  $nextYear++;
}
$disablePrevNav = $year < $currentYear || ($year === $currentYear && $month <= $currentMonth);

$monthNames = [
  1 => 'Janeiro',
  2 => 'Fevereiro',
  3 => 'Março',
  4 => 'Abril',
  5 => 'Maio',
  6 => 'Junho',
  7 => 'Julho',
  8 => 'Agosto',
  9 => 'Setembro',
  10 => 'Outubro',
  11 => 'Novembro',
  12 => 'Dezembro'
];

$filters = ['status' => 'disponivel'];
if ($type) {
  $filters['type'] = $type;
} elseif ($equipmentId) {
  $filters['id'] = $equipmentId;
}

$equipments = $equipmentModel->get(['id', 'name', 'description', 'type', 'image'], $filters);
$classes = $classModel->get();
$timeSlots = ScheduleModel::getTimeSlots();

$selectedDay = $day ?: $currentDay;
$selectedMonth = $month;
$selectedYear = $year;
$selectedDate = new DateTime("$selectedYear-$selectedMonth-$selectedDay");
if ($selectedDate < $currentDateMidnight) {
  $selectedDay = $currentDay;
  $selectedMonth = $currentMonth;
  $selectedYear = $currentYear;
  $selectedDate = $currentDateMidnight;
}

$formattedSelectedDate = $selectedDate->format('d') . ' de ' . $monthNames[(int)$selectedDate->format('n')] . ' de ' . $selectedDate->format('Y');
$inputSelectedDate = $selectedDate->format('Y-m-d');

if ($equipmentId) {
  $equipment = $equipmentModel->getInfo($equipmentId);
  if (!$equipment || $equipment['status'] !== 'disponivel') {
    Navigation::alert(
      'Equipamento Indisponível',
      'O equipamento selecionado não está disponível ou não existe.',
      'error',
      'index.php'
    );
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê | Agendar Equipamento</title>
  <link rel="shortcut icon" href="../../public/images/logo.svg" type="image/x-icon">
  <link href="../../public/css/output.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-emerald-50/80 to-teal-100/80 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-white min-h-screen font-sans overflow-x-hidden">
  <?php
  UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg');
  UI::renderAlerts(true);
  ?>

  <div class="fixed -top-24 -right-24 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="fixed top-1/3 -left-24 w-64 h-64 bg-teal-500/10 dark:bg-teal-600/10 rounded-full blur-3xl pointer-events-none"></div>
  <div class="fixed -bottom-32 right-20 w-80 h-80 bg-green-500/10 dark:bg-green-600/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="container mx-auto px-4 py-8 md:py-12 max-w-7xl relative z-10">
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-emerald-100/80 dark:border-emerald-900/30">
      <div class="bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-700 dark:to-teal-600 px-6 md:px-10 py-8 border-b border-emerald-500/20 dark:border-gray-600 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
          <div class="flex items-center gap-3 mb-2">
            <div class="bg-white/20 p-2.5 rounded-lg">
              <i class="fas fa-calendar-plus text-white text-xl"></i>
            </div>
            <h2 class="text-2xl md:text-3xl text-white font-bold tracking-tight">Agendar <?php echo $type ? Format::typeName($type) : 'Equipamento'; ?></h2>
          </div>
          <p class="text-emerald-50/90 text-sm md:text-base">Selecione o equipamento, data e horário para realizar seu agendamento</p>
        </div>
      </div>
      <form action="../src/controllers/schedule/book.php" method="POST" class="p-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
          <div class="lg:col-span-3 space-y-8">
            <div class="space-y-6">
              <div class="flex items-center justify-between">
                <label class="text-lg font-semibold text-gray-800 dark:text-gray-200">Equipamento Disponível</label>
                <span class="text-sm text-gray-500 dark:text-gray-400">Escolha um equipamento para agendar</span>
              </div>
              <div class="mt-4 bg-white dark:bg-gray-700/50 rounded-xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-600">
                <?php
                function renderEquipmentCard($equipment, $visible = true)
                {
                  $visibilityClass = $visible ? '' : 'hidden';
                  $imageUrl = !empty($equipment['image']) ? htmlspecialchars($equipment['image']) : 'https://placehold.co/900x600.png?text=' . Format::typeName($equipment['type']) . '&font=roboto';
                  $equipmentName = htmlspecialchars($equipment['name']);
                  $equipmentDescription = htmlspecialchars($equipment['description']);
                  $equipmentType = Format::typeName($equipment['type']);
                ?>
                  <div id="equipment-image-<?= htmlspecialchars($equipment['id']) ?>" class="equipment-image <?= $visibilityClass ?>">
                    <div class="relative overflow-hidden bg-gray-50 dark:bg-gray-800/50 aspect-video">
                      <img src="<?= $imageUrl ?>" class="w-full h-full object-contain transform transition-transform hover:scale-105" alt="<?= $equipmentName ?>">
                    </div>
                    <div class="p-6 bg-white dark:bg-gray-800/30 border-t border-gray-100 dark:border-gray-700">
                      <h3 class="font-semibold text-xl text-gray-800 dark:text-gray-100 mb-2"><?= $equipmentName ?></h3>
                      <p class="text-gray-600 dark:text-gray-400 leading-relaxed"><?= $equipmentDescription ?></p>
                      <div class="mt-4 flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-tag mr-2"></i>
                        <span><?= $equipmentType ?></span>
                      </div>
                    </div>
                  </div>
                <?php
                }
                if (!$equipmentId) { ?>
                  <div id="no-equipment-selected" class="flex flex-col items-center justify-center py-12 px-6 text-center">
                    <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-4">
                      <i class="fas fa-desktop text-3xl text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 font-medium">Selecione um equipamento para visualizar</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">As informações do equipamento aparecerão aqui</p>
                  </div>
                <?php
                  foreach ($equipments as $equipment) {
                    renderEquipmentCard($equipment, false);
                  }
                } else {
                  renderEquipmentCard($equipment, true);
                }
                ?>
              </div>
              <div class="relative mt-6">
                <select id="equipment-select" name="equipment_id"
                  class="w-full rounded-xl border-2 border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 px-4 py-3.5 appearance-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                  <option value="">Selecione um equipamento</option>
                  <?php foreach ($equipments as $equipment): ?>
                    <option value="<?php echo htmlspecialchars($equipment['id']); ?>" data-value="<?php echo htmlspecialchars($equipment['type']); ?>" <?php echo $equipment['id'] == $equipmentId ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($equipment['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-emerald-600 dark:text-emerald-400">
                  <i class="fas fa-chevron-down"></i>
                </div>
              </div>
            </div>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <label class="text-lg font-semibold text-gray-800 dark:text-gray-200">Turma</label>
                <span class="text-sm text-gray-500 dark:text-gray-400">Selecione a turma para o agendamento</span>
              </div>
              <div class="relative">
                <select name="class_id" required
                  class="w-full rounded-xl border-2 border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 px-4 py-3.5 appearance-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors">
                  <option value="">Selecione uma turma</option>
                  <?php foreach ($classes as $class): ?>
                    <option value="<?php echo htmlspecialchars($class['id']); ?>">
                      <?= htmlspecialchars($class['name']); ?> (<?= htmlspecialchars($class['grade'])?>ª Série)
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none text-emerald-600 dark:text-emerald-400">
                  <i class="fas fa-chevron-down"></i>
                </div>
              </div>
            </div>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <label class="text-lg font-semibold text-gray-800 dark:text-gray-200">Observações</label>
                <span class="text-sm text-gray-500 dark:text-gray-400">Adicione informações relevantes</span>
              </div>
              <textarea name="notes" rows="4" required
                class="w-full rounded-xl border-2 border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors resize-none"
                placeholder="Descreva detalhes importantes sobre o agendamento..."></textarea>
            </div>
          </div>
          <div class="lg:col-span-2 space-y-8">
            <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-sm border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden shadow-lg">
              <div class="bg-gradient-to-r from-emerald-500/10 to-green-500/10 dark:from-emerald-900/30 dark:to-green-900/30 px-6 py-4 border-b border-emerald-100 dark:border-gray-600 flex items-center justify-between">
                <button type="button" id="prev-month" class="w-10 h-10 flex items-center justify-center hover:bg-emerald-500/10 dark:hover:bg-emerald-700/30 rounded-full transition-all"
                  <?php echo $disablePrevNav ? 'disabled style="opacity: 0.4; cursor: not-allowed;"' : ''; ?>>
                  <i class="fas fa-chevron-left text-emerald-700 dark:text-emerald-400"></i>
                </button>
                <h2 class="text-xl font-bold text-emerald-800 dark:text-emerald-300" id="current-month"><?php echo $monthNames[$month] . ' ' . $year; ?></h2>
                <button type="button" id="next-month" class="w-10 h-10 flex items-center justify-center hover:bg-emerald-500/10 dark:hover:bg-emerald-700/30 rounded-full transition-all">
                  <i class="fas fa-chevron-right text-emerald-700 dark:text-emerald-400"></i>
                </button>
              </div>
              <div class="p-6">
                <div class="calendar-grid mb-4 gap-1">
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Dom</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Seg</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Ter</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Qua</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Qui</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Sex</div>
                  <div class="text-center font-medium text-emerald-800 dark:text-emerald-300">Sáb</div>
                </div>
                <div class="calendar-grid gap-1" id="calendar-days">
                  <?php
                  for ($i = $firstDayOfWeek - 1; $i >= 0; $i--) {
                    $prevDay = (new DateTime("$prevYear-$prevMonth-" . date('t', strtotime("$prevYear-$prevMonth-01"))))->modify("-$i days")->format('j');
                    echo "<div class=\"calendar-day disabled text-sm py-2 text-gray-400 dark:text-gray-500\">$prevDay</div>";
                  }
                  for ($day = 1; $day <= $daysInMonth; $day++) {
                    $isToday = ($day === $currentDay && $month === $currentMonth && $year === $currentYear);
                    $isSelected = ($day === $selectedDay && $month === $selectedMonth && $year === $selectedYear);
                    $isDisabled = ($year < $currentYear || ($year === $currentYear && $month < $currentMonth) ||
                      ($year === $currentYear && $month === $currentMonth && $day < $currentDay));
                    $classes = 'calendar-day text-sm py-2 transition-all hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg';
                    if ($isToday) $classes .= ' bg-emerald-100 dark:bg-emerald-900/50 font-bold text-emerald-700 dark:text-emerald-300';
                    if ($isSelected) $classes .= ' bg-emerald-500 dark:bg-emerald-600 text-white font-bold hover:bg-emerald-600 dark:hover:bg-emerald-700';
                    if ($isDisabled) $classes .= ' disabled text-gray-400 dark:text-gray-500 hover:bg-transparent dark:hover:bg-transparent cursor-not-allowed';
                    $dateAttr = $isDisabled ? '' : "data-date=\"$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT) . '"';
                    echo "<div class=\"$classes\" $dateAttr>$day</div>";
                  }
                  $totalCells = $firstDayOfWeek + $daysInMonth;
                  $remainingCells = 42 - $totalCells;
                  for ($i = 1; $i <= $remainingCells; $i++) {
                    echo "<div class=\"calendar-day disabled text-sm py-2 text-gray-400 dark:text-gray-500\">$i</div>";
                  }
                  ?>
                </div>
                <div class="mt-6 text-center">
                  <input type="hidden" name="selected_date" id="selected_date" value="<?php echo $inputSelectedDate; ?>">
                  <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Data selecionada: <span id="formatted_date" class="text-emerald-600 dark:text-emerald-400 font-semibold"><?php echo $formattedSelectedDate; ?></span></p>
                </div>
              </div>
            </div>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <label class="text-lg font-semibold text-gray-800 dark:text-gray-200">Horário</label>
                <span class="text-sm text-gray-500 dark:text-gray-400">Selecione os horários desejados</span>
              </div>
              <div class="time-slot-container border border-gray-100 dark:border-gray-700 rounded-xl bg-white/80 dark:bg-gray-800/90 backdrop-blur-sm shadow-lg overflow-hidden relative">
                <div class="border-b border-emerald-100 dark:border-gray-700">
                  <div class="px-6 py-3 bg-gradient-to-r from-emerald-500/10 to-green-500/10 dark:from-emerald-900/30 dark:to-green-900/30">
                    <h3 class="font-semibold text-emerald-800 dark:text-emerald-300">Manhã</h3>
                  </div>
                  <div class="p-4 space-y-2" id="morning-slots">
                    <?php
                    $isPastDate = $selectedDate < $currentDateMidnight;
                    foreach ($timeSlots as $slot) {
                      if ($slot['period'] === 'matutino') {
                        $slotStart = new DateTime($selectedDate->format('Y-m-d') . ' ' . $slot['start']);
                        $isDisabled = $isPastDate || ($selectedDate == $currentDateMidnight && $slotStart < $currentDate);
                        echo '<label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all' . ($isDisabled ? ' past-slot' : '') . '">';
                        echo '<input type="checkbox" name="time_slots[]" value="' . htmlspecialchars($slot['id']) . '" ' .
                          'class="rounded border-2 border-emerald-200 dark:border-emerald-800 text-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-400"' .
                          ($isDisabled ? ' disabled' : '') . '>';
                        echo '<span class="slot-text">' . htmlspecialchars($slot['name']) . ' (' . htmlspecialchars($slot['start']) . ' - ' . htmlspecialchars($slot['end']) . ')</span>';
                        echo '</label>';
                      }
                    }
                    ?>
                  </div>
                </div>
                <div>
                  <div class="px-6 py-3 bg-gradient-to-r from-emerald-500/10 to-green-500/10 dark:from-emerald-900/30 dark:to-green-900/30">
                    <h3 class="font-semibold text-emerald-800 dark:text-emerald-300">Tarde</h3>
                  </div>
                  <div class="p-4 space-y-2" id="afternoon-slots">
                    <?php
                    foreach ($timeSlots as $slot) {
                      if ($slot['period'] === 'vespertino') {
                        $slotStart = new DateTime($selectedDate->format('Y-m-d') . ' ' . $slot['start']);
                        $isDisabled = $isPastDate || ($selectedDate == $currentDateMidnight && $slotStart < $currentDate);
                        echo '<label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all' . ($isDisabled ? ' past-slot' : '') . '">';
                        echo '<input type="checkbox" name="time_slots[]" value="' . htmlspecialchars($slot['id']) . '" ' .
                          'class="rounded border-2 border-emerald-200 dark:border-emerald-800 text-emerald-600 focus:ring-emerald-500 dark:focus:ring-emerald-400"' .
                          ($isDisabled ? ' disabled' : '') . '>';
                        echo '<span class="slot-text">' . htmlspecialchars($slot['name']) . ' (' . htmlspecialchars($slot['start']) . ' - ' . htmlspecialchars($slot['end']) . ')</span>';
                        echo '</label>';
                      }
                    }
                    ?>
                  </div>
                </div>
                <div id="loading-indicator" class="hidden absolute inset-0 bg-white/50 dark:bg-gray-800/50 flex items-center justify-center">
                  <i class="fas fa-spinner fa-spin text-emerald-600 dark:text-emerald-400 text-2xl"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-10 flex justify-end space-x-4">
          <button type="button" onclick="window.history.back()"
            class="px-6 py-3 rounded-xl border-2 border-emerald-200 dark:border-emerald-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-all font-semibold text-emerald-700 dark:text-emerald-400">
            Cancelar
          </button>
          <button type="submit"
            class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-500 hover:from-emerald-700 hover:to-green-600 text-white rounded-xl transition-all font-semibold shadow-lg shadow-emerald-500/20 dark:shadow-emerald-900/30">
            <i class="fas fa-calendar-check mr-2"></i>Agendar
          </button>
        </div>
      </form>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const config = {
        currentMonth: <?php echo $month; ?>,
        currentYear: <?php echo $year; ?>,
        currentSystemMonth: <?php echo $currentMonth; ?>,
        currentSystemYear: <?php echo $currentYear; ?>,
        currentSystemDay: <?php echo $currentDay; ?>,
        monthNames: <?php echo json_encode($monthNames); ?>,
        timeSlots: <?php echo json_encode($timeSlots); ?>
      };

      const elements = {
        equipmentSelect: document.getElementById('equipment-select'),
        noEquipmentSelected: document.getElementById('no-equipment-selected'),
        equipmentImages: document.querySelectorAll('.equipment-image'),
        prevMonthBtn: document.getElementById('prev-month'),
        nextMonthBtn: document.getElementById('next-month'),
        currentMonthDisplay: document.getElementById('current-month'),
        calendarDays: document.getElementById('calendar-days'),
        selectedDateInput: document.getElementById('selected_date'),
        formattedDateDisplay: document.getElementById('formatted_date'),
        morningSlots: document.getElementById('morning-slots'),
        afternoonSlots: document.getElementById('afternoon-slots'),
        loadingIndicator: document.getElementById('loading-indicator')
      };

      let state = {
        currentMonth: config.currentMonth,
        currentYear: config.currentYear,
        selectedDate: elements.selectedDateInput.value,
        bookedTimeSlots: []
      };

      function updateEquipmentDisplay() {
        if (elements.noEquipmentSelected) {
          elements.noEquipmentSelected.classList.add('hidden');
        }
        elements.equipmentImages.forEach(img => img.classList.add('hidden'));
        const selectedValue = elements.equipmentSelect.value;
        if (selectedValue) {
          const selectedImage = document.getElementById(`equipment-image-${selectedValue}`);
          if (selectedImage) {
            selectedImage.classList.remove('hidden');
          } else {
            console.warn(`Equipment image for ID ${selectedValue} not found.`);
            if (elements.noEquipmentSelected) {
              elements.noEquipmentSelected.classList.remove('hidden');
            }
          }
          fetchBookedTimeSlots();
        } else {
          if (elements.noEquipmentSelected) {
            elements.noEquipmentSelected.classList.remove('hidden');
          }
          resetTimeSlots();
        }
      }

      function resetTimeSlots() {
        state.bookedTimeSlots = [];
        updateTimeSlots();
      }

      function updateCalendar() {
        elements.currentMonthDisplay.textContent = `${config.monthNames[state.currentMonth]} ${state.currentYear}`;
        const firstDay = new Date(state.currentYear, state.currentMonth - 1, 1);
        const lastDay = new Date(state.currentYear, state.currentMonth, 0);
        const daysInMonth = lastDay.getDate();
        const firstDayOfWeek = firstDay.getDay();
        let html = '';

        const prevMonthDays = new Date(state.currentYear, state.currentMonth - 1, 0).getDate();
        for (let i = firstDayOfWeek - 1; i >= 0; i--) {
          html += `<div class="calendar-day disabled text-sm py-2 text-gray-400 dark:text-gray-500">${prevMonthDays - i}</div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
          const isToday = day === config.currentSystemDay && state.currentMonth === config.currentSystemMonth && state.currentYear === config.currentSystemYear;
          const isSelected = day === parseInt(state.selectedDate.split('-')[2]) && state.currentMonth === parseInt(state.selectedDate.split('-')[1]) && state.currentYear === parseInt(state.selectedDate.split('-')[0]);
          const isDisabled = state.currentYear < config.currentSystemYear ||
            (state.currentYear === config.currentSystemYear && state.currentMonth < config.currentSystemMonth) ||
            (state.currentYear === config.currentSystemYear && state.currentMonth === config.currentSystemMonth && day < config.currentSystemDay);
          let classes = 'calendar-day text-sm py-2 transition-all hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-lg';
          if (isToday) classes += ' bg-emerald-100 dark:bg-emerald-900/50 font-bold text-emerald-700 dark:text-emerald-300';
          if (isSelected) classes += ' bg-emerald-500 dark:bg-emerald-600 text-white font-bold hover:bg-emerald-600 dark:hover:bg-emerald-700';
          if (isDisabled) classes += ' disabled text-gray-400 dark:text-gray-500 hover:bg-transparent dark:hover:bg-transparent cursor-not-allowed';
          const dateAttr = isDisabled ? '' : `data-date="${state.currentYear}-${String(state.currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}"`;
          html += `<div class="${classes}" ${dateAttr}>${day}</div>`;
        }

        const totalCells = firstDayOfWeek + daysInMonth;
        const remainingCells = 42 - totalCells;
        for (let i = 1; i <= remainingCells; i++) {
          html += `<div class="calendar-day disabled text-sm py-2 text-gray-400 dark:text-gray-500">${i}</div>`;
        }

        elements.calendarDays.innerHTML = html;
        elements.calendarDays.querySelectorAll('.calendar-day[data-date]').forEach(day => day.addEventListener('click', handleDayClick));

        elements.prevMonthBtn.disabled = state.currentYear < config.currentSystemYear || (state.currentYear === config.currentSystemYear && state.currentMonth <= config.currentSystemMonth);
        elements.prevMonthBtn.style.opacity = elements.prevMonthBtn.disabled ? '0.4' : '1';
        elements.prevMonthBtn.style.cursor = elements.prevMonthBtn.disabled ? 'not-allowed' : 'pointer';
      }

      function handleDayClick(e) {
        elements.calendarDays.querySelectorAll('.calendar-day').forEach(day => day.classList.remove('bg-emerald-500', 'dark:bg-emerald-600', 'text-white', 'font-bold', 'hover:bg-emerald-600', 'dark:hover:bg-emerald-700'));
        e.target.classList.add('bg-emerald-500', 'dark:bg-emerald-600', 'text-white', 'font-bold', 'hover:bg-emerald-600', 'dark:hover:bg-emerald-700');
        state.selectedDate = e.target.getAttribute('data-date');
        elements.selectedDateInput.value = state.selectedDate;
        const [year, month, day] = state.selectedDate.split('-').map(Number);
        elements.formattedDateDisplay.textContent = `${String(day).padStart(2, '0')} de ${config.monthNames[month]} de ${year}`;
        fetchBookedTimeSlots();
      }

      async function fetchBookedTimeSlots() {
        if (!elements.equipmentSelect.value || !state.selectedDate || !/^\d{4}-\d{2}-\d{2}$/.test(state.selectedDate)) {
          resetTimeSlots();
          return;
        }
        elements.loadingIndicator.classList.remove('hidden');
        try {
          const response = await fetch('../src/controllers/schedule/getBookedSlots.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `equipment_id=${encodeURIComponent(elements.equipmentSelect.value)}&date=${encodeURIComponent(state.selectedDate)}`
          });
          if (!response.ok) {
            const text = await response.text();
            console.error('Non-OK response:', response.status, text);
            throw new Error('Erro na requisição AJAX');
          }
          const data = await response.json();
          state.bookedTimeSlots = data;
          updateTimeSlots();
        } catch (error) {
          console.error('Erro ao buscar horários agendados:', error);
          state.bookedTimeSlots = [];
          updateTimeSlots();
        } finally {
          elements.loadingIndicator.classList.add('hidden');
        }
      }

      function updateTimeSlots() {
        const [year, month, day] = state.selectedDate.split('-').map(Number);
        const selectedDateTime = new Date(year, month - 1, day);
        const isToday = year === config.currentSystemYear && month === config.currentSystemMonth && day === config.currentSystemDay;

        function updateSlotCheckboxes(container, period) {
          container.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            const slot = config.timeSlots.find(s => s.id === checkbox.value);
            if (slot && slot.period === period) {
              const [hours, minutes] = slot.start.split(':').map(Number);
              const slotTime = new Date(year, month - 1, day, hours, minutes);
              const isPast = isToday && slotTime < new Date();
              const isBooked = state.bookedTimeSlots.includes(checkbox.value);
              const isDisabled = isPast || isBooked;
              checkbox.disabled = isDisabled;
              const label = checkbox.parentElement;
              const textSpan = label.querySelector('.slot-text');
              label.classList.toggle('past-slot', isPast);
              textSpan.classList.toggle('booked-slot', isBooked && !isPast);
            }
          });
        }

        updateSlotCheckboxes(elements.morningSlots, 'matutino');
        updateSlotCheckboxes(elements.afternoonSlots, 'vespertino');
      }

      elements.equipmentSelect.addEventListener('change', updateEquipmentDisplay);

      elements.prevMonthBtn.addEventListener('click', () => {
        if (state.currentMonth === 1) {
          state.currentMonth = 12;
          state.currentYear--;
        } else {
          state.currentMonth--;
        }
        updateCalendar();
      });

      elements.nextMonthBtn.addEventListener('click', () => {
        if (state.currentMonth === 12) {
          state.currentMonth = 1;
          state.currentYear++;
        } else {
          state.currentMonth++;
        }
        updateCalendar();
      });

      updateCalendar();
      updateEquipmentDisplay();
      if (elements.equipmentSelect.value) fetchBookedTimeSlots();
    });
  </script>
  <?php UI::renderFooter('../'); ?>
</body>

</html>