<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$equipmentId = isset($_GET['id']) ? Security::show((string)$_GET['id']) : null;
$type = isset($_GET['type']) ? (string)$_GET['type'] : null;

$currentDate = new DateTime();
$currentYear = $currentDate->format('Y');
$currentMonth = $currentDate->format('n');
$currentDay = $currentDate->format('j');
$currentHour = $currentDate->format('H');
$currentMinute = $currentDate->format('i');

$month = isset($_GET['month']) ? (int)$_GET['month'] : $currentMonth;
$year = isset($_GET['year']) ? (int)$_GET['year'] : $currentYear;

if ($year < $currentYear || ($year == $currentYear && $month < $currentMonth)) {
  $month = $currentMonth;
  $year = $currentYear;
}

$firstDayOfMonth = new DateTime("$year-$month-01");
$lastDayOfMonth = new DateTime($firstDayOfMonth->format('Y-m-t'));
$daysInMonth = $lastDayOfMonth->format('j');
$firstDayOfWeek = $firstDayOfMonth->format('w');

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

$disablePrevNav = ($year < $currentYear || ($year == $currentYear && $month <= $currentMonth));

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
} else if ($equipmentId) {
  $filters['id'] = $equipmentId;
}

$equipments = $equipmentController->get(['id', 'name', 'description', 'type', 'image'], $filters);

$classes = $classController->get();

$timeSlots = ScheduleController::getTimeSlots();

$selectedDay = isset($_GET['day']) ? (int)$_GET['day'] : $currentDay;
$selectedMonth = isset($_GET['month']) ? (int)$_GET['month'] : $currentMonth;
$selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : $currentYear;

$selectedDate = new DateTime("$selectedYear-$selectedMonth-$selectedDay");
$currentDateMidnight = new DateTime($currentDate->format('Y-m-d'));

if ($selectedDate < $currentDateMidnight) {
  $selectedDay = $currentDay;
  $selectedMonth = $currentMonth;
  $selectedYear = $currentYear;
  $selectedDate = $currentDateMidnight;
}

$formattedSelectedDate = $selectedDate->format('d') . ' de ' . $monthNames[(int)$selectedDate->format('n')] . ' de ' . $selectedDate->format('Y');
$inputSelectedDate = $selectedDate->format('Y-m-d');
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê | Agendar Equipamento</title>
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="shortcut icon" href="../../public/assets/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 8px;
    }

    .calendar-day {
      aspect-ratio: 1/1;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }

    .calendar-day.today {
      border: 2px solid #22c55e;
    }

    .calendar-day.selected {
      background-color: #22c55e;
      color: white;
    }

    .calendar-day.disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }

    .dark .calendar-day.today {
      border-color: #16a34a;
    }

    .dark .calendar-day.selected {
      background-color: #16a34a;
    }

    .calendar-day:not(.disabled):not(.selected):hover {
      background-color: #f3f4f6;
    }

    .dark .calendar-day:not(.disabled):not(.selected):hover {
      background-color: #374151;
    }

    .equipment-image {
      transition: opacity 0.3s ease-in-out;
    }

    .time-slot-container {
      max-height: 300px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #d1d5db transparent;
    }

    .time-slot-container::-webkit-scrollbar {
      width: 6px;
    }

    .time-slot-container::-webkit-scrollbar-track {
      background: transparent;
    }

    .time-slot-container::-webkit-scrollbar-thumb {
      background-color: #d1d5db;
      border-radius: 20px;
    }

    .dark .time-slot-container {
      scrollbar-color: #4b5563 transparent;
    }

    .dark .time-slot-container::-webkit-scrollbar-thumb {
      background-color: #4b5563;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-white min-h-screen">

  <?php UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg'); ?>

  <div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden">
      <div class="bg-green-600 dark:bg-green-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
        <h1 class="text-2xl text-white font-bold">Agendar <?php echo $type ? Format::typeName($type) : 'Equipamento'; ?></h1>
      </div>

      <form action="../src/handlers/schedule/book.php" method="POST" class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
          <div class="lg:col-span-3 space-y-6">
            <div class="space-y-4">
              <label class="block text-sm font-medium">
                Equipamento Disponível
              </label>

              <div class="mt-4 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                <div id="no-equipment-selected" class="flex flex-col items-center justify-center py-8 px-4 text-center">
                  <i class="fas fa-desktop text-4xl mb-3 text-gray-400 dark:text-gray-500"></i>
                  <p class="text-gray-500 dark:text-gray-400">Selecione um equipamento para visualizar</p>
                </div>

                <?php foreach ($equipments as $equipment): ?>
                  <div id="equipment-image-<?php echo $equipment['type']; ?>" class="equipment-image hidden">
                    <img src="<?php echo !empty($equipment['image']) ? htmlspecialchars($equipment['image']) : 'https://placehold.co/900x600.png?text=' . Format::typeName($equipment['type']) . '&font=poppings'; ?>"
                      class="w-full h-64 object-contain" alt="<?php echo htmlspecialchars($equipment['name']); ?>">
                    <div class="p-4 bg-white dark:bg-gray-800">
                      <h3 class="font-medium text-lg"><?php echo htmlspecialchars($equipment['name']); ?></h3>
                      <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($equipment['description']); ?></p>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <select id="equipment-select" name="equipment_id" required
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                <?php if (!$equipmentId) {
                  echo '<option value="">Selecione um equipamento</option>';
                } ?>
                <?php foreach ($equipments as $equipment): ?>
                  <option value="<?php echo $equipment['id']; ?>" data-value="<?php echo $equipment['type']; ?>">
                    <?php echo htmlspecialchars($equipment['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium">
                Turma
              </label>
              <select name="class_id"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">Selecione uma turma (opcional)</option>
                <?php foreach ($classes as $class): ?>
                  <option value="<?php echo $class['id']; ?>">
                    <?php echo htmlspecialchars($class['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium">
                Observações (opcional)
              </label>
              <textarea name="notes" rows="3"
                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent"
                placeholder="Adicione informações relevantes sobre o agendamento..."></textarea>
            </div>
          </div>

          <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm">
              <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 flex items-center justify-between">
                <button type="button" id="prev-month" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors"
                  <?php echo $disablePrevNav ? 'disabled' : ''; ?>
                  <?php echo $disablePrevNav ? 'style="opacity: 0.4; cursor: not-allowed;"' : ''; ?>>
                  <i class="fas fa-chevron-left"></i>
                </button>
                <h2 class="text-lg font-semibold" id="current-month"><?php echo $monthNames[$month] . ' ' . $year; ?></h2>
                <button type="button" id="next-month" class="p-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full transition-colors">
                  <i class="fas fa-chevron-right"></i>
                </button>
              </div>

              <div class="p-4">
                <div class="calendar-grid mb-2">
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Dom</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Seg</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Ter</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Qua</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Qui</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Sex</div>
                  <div class="text-center text-sm font-medium text-gray-500 dark:text-gray-400">Sáb</div>
                </div>

                <div class="calendar-grid" id="calendar-days">
                  <?php
                  $prevMonthDays = $firstDayOfWeek;
                  for ($i = $prevMonthDays - 1; $i >= 0; $i--) {
                    echo '<div class="calendar-day disabled">' . (new DateTime("$prevYear-$prevMonth-" . date('t', strtotime("$prevYear-$prevMonth-01"))))->modify("-$i days")->format('j') . '</div>';
                  }

                  for ($day = 1; $day <= $daysInMonth; $day++) {
                    $isToday = ($day == $currentDay && $month == $currentMonth && $year == $currentYear);
                    $isSelected = ($day == $selectedDay && $month == $selectedMonth && $year == $selectedYear);
                    $isDisabled = ($year < $currentYear || ($year == $currentYear && $month < $currentMonth) ||
                      ($year == $currentYear && $month == $currentMonth && $day < $currentDay));

                    $classes = 'calendar-day';
                    if ($isToday) $classes .= ' today';
                    if ($isSelected) $classes .= ' selected';
                    if ($isDisabled) $classes .= ' disabled';

                    echo '<div class="' . $classes . '" ' . (!$isDisabled ? 'data-date="' . sprintf("%04d-%02d-%02d", $year, $month, $day) . '"' : '') . '>' . $day . '</div>';
                  }

                  $totalCurrentMonthCells = $prevMonthDays + $daysInMonth;
                  $nextMonthDays = 42 - $totalCurrentMonthCells;
                  for ($i = 1; $i <= $nextMonthDays; $i++) {
                    echo '<div class="calendar-day disabled">' . $i . '</div>';
                  }
                  ?>
                </div>

                <div class="mt-4 text-center">
                  <input type="hidden" name="selected_date" id="selected_date" value="<?php echo $inputSelectedDate; ?>">
                  <p class="text-sm font-medium">Data selecionada: <span id="formatted_date" class="text-primary dark:text-primary-dark"><?php echo $formattedSelectedDate; ?></span></p>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-medium flex items-center justify-between">
                <span>Horário</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">(Selecione os horários desejados)</span>
              </label>
              <div class="time-slot-container border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 shadow-sm">
                <div class="border-b border-gray-200 dark:border-gray-700">
                  <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700">
                    <h3 class="font-medium text-sm">Manhã</h3>
                  </div>
                  <div class="p-2 space-y-1" id="morning-slots">
                    <?php
                    $isPastDate = $selectedDate < $currentDateMidnight;

                    foreach ($timeSlots as $slot) {
                      if ($slot['period'] === 'matutino') {
                        $slotStart = new DateTime($selectedDate->format('Y-m-d') . ' ' . $slot['start']);
                        $isDisabled = $isPastDate || ($selectedDate == $currentDateMidnight && $slotStart < $currentDate);

                        echo '<label class="flex items-center space-x-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors ' . ($isDisabled ? 'opacity-40' : '') . '">';
                        echo '<input type="checkbox" name="time_slots[]" value="' . $slot['id'] . '" ' .
                          'class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary dark:focus:ring-primary-dark" ' .
                          ($isDisabled ? 'disabled' : '') . '>';
                        echo '<span>' . $slot['name'] . ' (' . $slot['start'] . ' - ' . $slot['end'] . ')</span>';
                        echo '</label>';
                      }
                    }
                    ?>
                  </div>
                </div>

                <div>
                  <div class="px-4 py-2 bg-gray-50 dark:bg-gray-700">
                    <h3 class="font-medium text-sm">Tarde</h3>
                  </div>
                  <div class="p-2 space-y-1" id="afternoon-slots">
                    <?php
                    foreach ($timeSlots as $slot) {
                      if ($slot['period'] === 'vespertino') {
                        $slotStart = new DateTime($selectedDate->format('Y-m-d') . ' ' . $slot['start']);
                        $isDisabled = $isPastDate || ($selectedDate == $currentDateMidnight && $slotStart < $currentDate);

                        echo '<label class="flex items-center space-x-2 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors ' . ($isDisabled ? 'opacity-40' : '') . '">';
                        echo '<input type="checkbox" name="time_slots[]" value="' . $slot['id'] . '" ' .
                          'class="rounded border-gray-300 dark:border-gray-600 text-primary focus:ring-primary dark:focus:ring-primary-dark" ' .
                          ($isDisabled ? 'disabled' : '') . '>';
                        echo '<span>' . $slot['name'] . ' (' . $slot['start'] . ' - ' . $slot['end'] . ')</span>';
                        echo '</label>';
                      }
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-8 flex justify-end space-x-3">
          <button type="button" onclick="window.history.back()"
            class="px-5 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors font-medium">
            Cancelar
          </button>
          <button type="submit"
            class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium dark:bg-green-700 dark:hover:bg-green-800">
            Agendar
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let currentMonth = <?php echo $month; ?>;
      let currentYear = <?php echo $year; ?>;
      const currentSystemMonth = <?php echo $currentMonth; ?>;
      const currentSystemYear = <?php echo $currentYear; ?>;
      const currentSystemDay = <?php echo $currentDay; ?>;
      const monthNames = <?php echo json_encode($monthNames); ?>;
      const timeSlots = <?php echo json_encode($timeSlots); ?>;

      const equipmentSelect = document.getElementById('equipment-select');
      const noEquipmentSelected = document.getElementById('no-equipment-selected');
      const equipmentImages = document.querySelectorAll('.equipment-image');

      equipmentSelect.addEventListener('change', function() {
        noEquipmentSelected.classList.add('hidden');
        equipmentImages.forEach(image => image.classList.add('hidden'));

        const selectedValue = this.options[this.selectedIndex].getAttribute('data-value');

        if (selectedValue) {
          const selectedImage = document.getElementById('equipment-image-' + selectedValue);
          if (selectedImage) {
            selectedImage.classList.remove('hidden');
          }
        } else {
          noEquipmentSelected.classList.remove('hidden');
        }
      });

      document.getElementById('prev-month').addEventListener('click', function() {
        const newDate = new Date(currentYear, currentMonth - 2, 1);

        if (newDate.getFullYear() < currentSystemYear ||
          (newDate.getFullYear() === currentSystemYear && newDate.getMonth() + 1 < currentSystemMonth)) {
          return;
        }

        currentMonth--;
        if (currentMonth < 1) {
          currentMonth = 12;
          currentYear--;
        }

        updateCalendar();
      });

      document.getElementById('next-month').addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 12) {
          currentMonth = 1;
          currentYear++;
        }

        updateCalendar();
      });

      function updateCalendar() {
        document.getElementById('current-month').textContent = monthNames[currentMonth] + ' ' + currentYear;

        const firstDayOfMonth = new Date(currentYear, currentMonth - 1, 1);
        const lastDayOfMonth = new Date(currentYear, currentMonth, 0);
        const daysInMonth = lastDayOfMonth.getDate();
        const firstDayOfWeek = firstDayOfMonth.getDay();

        let calendarHTML = '';

        const prevMonth = currentMonth - 1 > 0 ? currentMonth - 1 : 12;
        const prevYear = prevMonth === 12 ? currentYear - 1 : currentYear;
        const prevMonthDays = new Date(prevYear, prevMonth, 0).getDate();

        for (let i = firstDayOfWeek - 1; i >= 0; i--) {
          calendarHTML += `<div class="calendar-day disabled">${prevMonthDays - i}</div>`;
        }

        for (let day = 1; day <= daysInMonth; day++) {
          const isToday = (day === currentSystemDay && currentMonth === currentSystemMonth && currentYear === currentSystemYear);
          const isSelected = false;
          const isDisabled = (currentYear < currentSystemYear ||
            (currentYear === currentSystemYear && currentMonth < currentSystemMonth) ||
            (currentYear === currentSystemYear && currentMonth === currentSystemMonth && day < currentSystemDay));

          let classes = 'calendar-day';
          if (isToday) classes += ' today';
          if (isSelected) classes += ' selected';
          if (isDisabled) classes += ' disabled';

          const dateAttr = !isDisabled ? `data-date="${currentYear}-${String(currentMonth).padStart(2, '0')}-${String(day).padStart(2, '0')}"` : '';

          calendarHTML += `<div class="${classes}" ${dateAttr}>${day}</div>`;
        }

        const totalDays = firstDayOfWeek + daysInMonth;
        const remainingCells = 42 - totalDays;

        for (let i = 1; i <= remainingCells; i++) {
          calendarHTML += `<div class="calendar-day disabled">${i}</div>`;
        }

        document.getElementById('calendar-days').innerHTML = calendarHTML;

        document.querySelectorAll('.calendar-day[data-date]').forEach(day => {
          day.addEventListener('click', handleDayClick);
        });

        const prevMonthBtn = document.getElementById('prev-month');
        if (currentYear < currentSystemYear || (currentYear === currentSystemYear && currentMonth <= currentSystemMonth)) {
          prevMonthBtn.disabled = true;
          prevMonthBtn.style.opacity = '0.4';
          prevMonthBtn.style.cursor = 'not-allowed';
        } else {
          prevMonthBtn.disabled = false;
          prevMonthBtn.style.opacity = '1';
          prevMonthBtn.style.cursor = 'pointer';
        }
      }

      function handleDayClick(e) {
        document.querySelectorAll('.calendar-day.selected').forEach(day => {
          day.classList.remove('selected');
        });

        e.target.classList.add('selected');

        const selectedDate = e.target.getAttribute('data-date');
        document.getElementById('selected_date').value = selectedDate;

        const [year, month, day] = selectedDate.split('-').map(Number);
        const formattedDate = `${String(day).padStart(2, '0')} de ${monthNames[month]} de ${year}`;
        document.getElementById('formatted_date').textContent = formattedDate;

        updateTimeSlots(selectedDate);
      }

      function updateTimeSlots(selectedDate) {
        const [year, month, day] = selectedDate.split('-').map(Number);
        const selectedDateTime = new Date(year, month - 1, day);
        const currentDateTime = new Date(currentSystemYear, currentSystemMonth - 1, currentSystemDay);

        const isToday = selectedDateTime.getFullYear() === currentDateTime.getFullYear() &&
          selectedDateTime.getMonth() === currentDateTime.getMonth() &&
          selectedDateTime.getDate() === currentDateTime.getDate();

        document.querySelectorAll('#morning-slots input[type="checkbox"]').forEach((checkbox, index) => {
          const timeSlot = timeSlots.find(slot => slot.id === checkbox.value);
          if (timeSlot) {
            const [hours, minutes] = timeSlot.start.split(':').map(Number);
            const slotTime = new Date(year, month - 1, day, hours, minutes);

            const isDisabled = isToday && slotTime < new Date();
            checkbox.disabled = isDisabled;
            checkbox.parentElement.classList.toggle('opacity-40', isDisabled);
          }
        });

        document.querySelectorAll('#afternoon-slots input[type="checkbox"]').forEach((checkbox, index) => {
          const timeSlot = timeSlots.find(slot => slot.id === checkbox.value);
          if (timeSlot) {
            const [hours, minutes] = timeSlot.start.split(':').map(Number);
            const slotTime = new Date(year, month - 1, day, hours, minutes);

            const isDisabled = isToday && slotTime < new Date();
            checkbox.disabled = isDisabled;
            checkbox.parentElement.classList.toggle('opacity-40', isDisabled);
          }
        });
      }

      updateCalendar();

      document.querySelectorAll('.calendar-day[data-date]').forEach(day => {
        day.addEventListener('click', handleDayClick);
      });

      const selectedDay = document.querySelector('.calendar-day.selected');
      if (selectedDay) {
        selectedDay.click();
      }

      if (equipmentSelect.value) {
        const selectedOption = equipmentSelect.options[equipmentSelect.selectedIndex];
        const selectedValue = selectedOption.getAttribute('data-value');
        if (selectedValue) {
          const selectedImage = document.getElementById('equipment-image-' + selectedValue);
          if (selectedImage) {
            noEquipmentSelected.classList.add('hidden');
            selectedImage.classList.remove('hidden');
          }
        }
      }
    });
  </script>

  <?php UI::renderFooter('../'); ?>
</body>

</html>