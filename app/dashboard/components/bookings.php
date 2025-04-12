<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-slate-700 shadow-sm scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 scrollbar-track-gray-200 dark:scrollbar-track-gray-700">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
    <thead class="bg-gray-50 dark:bg-slate-700/50">
      <tr>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Equipamento</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Solicitante</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Turma</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Horário</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Data</th>
      </tr>
    </thead>
    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
      <?php
      $bookings = $scheduleController->get(['limit' => 5, 'date' => date('d-m-Y')]);

      $timeSlots = array_column(ScheduleController::getTimeSlots(), null, 'id');

      if (!empty($bookings)) {
        foreach ($bookings as $booking) {
          $equipment = $booking['equipment_info'] ?? 'N/A';
          $user = $booking['user_info'] ?? 'N/A';
          $class = $booking['class_info'] ?? 'N/A';
          $date = date('d/m/Y', strtotime($booking['date']));
          $scheduleId = $booking['schedule'] ?? 'N/A';
          $schedule = isset($timeSlots[$scheduleId])
            ? $timeSlots[$scheduleId]['name'] . ' (' . $timeSlots[$scheduleId]['start'] . ' - ' . $timeSlots[$scheduleId]['end'] . ')'
            : 'N/A';
      ?>
          <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all duration-200 ease-in-out">
            <td class="py-4 px-6 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
              <a class="text-cyan-500 hover:text-cyan-600 dark:text-cyan-400 dark:hover:text-cyan-300 font-bold" href="./pages/equipamentos.php?id=<?= Security::hide($equipment['id']) ?>">
                <?= htmlspecialchars($equipment['name']); ?>
              </a>
            </td>
            <td class="py-4 px-6 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
              <a class="text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 font-bold" href="../perfil.php?id=<?= Security::hide($user['id']) ?>">
                <?= htmlspecialchars($user['name']); ?>
              </a>
            </td>
            <td class="py-4 px-6 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
              <a class="text-green-500 hover:text-green-600 dark:text-green-400 dark:hover:text-green-300 font-bold" href="./pages/turmas.php?id=<?= Security::hide($class['id']) ?>">
                <?= htmlspecialchars($class['name']); ?>
              </a>
            </td>
            <td class="py-4 px-6 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap"><?= htmlspecialchars($schedule); ?></td>
            <td class="py-4 px-6 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap"><?= htmlspecialchars($date); ?></td>
          </tr>
      <?php
        }
      } else {
        echo '<tr><td colspan="5" class="py-8 px-6 text-center text-sm text-gray-600 dark:text-gray-400">Nenhum agendamento encontrado para hoje</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>