<div class="overflow-x-auto border border-blue-100 dark:border-blue-900/30 shadow-2xl scrollbar-thin scrollbar-thumb-blue-400 dark:scrollbar-thumb-blue-700 scrollbar-track-blue-100 dark:scrollbar-track-blue-900 bg-white/90 dark:bg-gray-900/80">
  <table class="min-w-full divide-y divide-blue-100 dark:divide-blue-900/40">
    <thead class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20">
      <tr>
        <th class="py-5 px-7 text-left text-xs font-black text-blue-700 dark:text-blue-200 uppercase tracking-widest">Equipamento</th>
        <th class="py-5 px-7 text-left text-xs font-black text-purple-700 dark:text-purple-200 uppercase tracking-widest">Solicitante</th>
        <th class="py-5 px-7 text-left text-xs font-black text-emerald-700 dark:text-emerald-200 uppercase tracking-widest">Turma</th>
        <th class="py-5 px-7 text-left text-xs font-black text-blue-700 dark:text-blue-200 uppercase tracking-widest">Horário</th>
        <th class="py-5 px-7 text-left text-xs font-black text-amber-700 dark:text-amber-200 uppercase tracking-widest">Data</th>
      </tr>
    </thead>
    <tbody class="bg-white/80 dark:bg-gray-900/60 divide-y divide-blue-50 dark:divide-blue-900/20">
      <?php
      $bookings = $scheduleModel->get(['limit' => 5, 'date' => date('d-m-Y')]);
      $timeSlots = array_column(ScheduleModel::getTimeSlots(), null, 'id');
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
          <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 transition-all duration-200 ease-in-out cursor-pointer" onclick="window.location.href='../agendae/agendamento.php?id=<?= Security::hide($booking['id']) ?>'">
            <td class="py-5 px-7 text-base text-blue-900 dark:text-blue-100 whitespace-nowrap font-semibold">
              <div class="flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-bold">
                <span class="bg-cyan-100 dark:bg-cyan-900/50 p-2 rounded-xl">
                  <i class="fas fa-desktop text-cyan-500 dark:text-cyan-400 text-lg"></i>
                </span>
                <?= htmlspecialchars($equipment['name']); ?>
              </div>
            </td>
            <td class="py-5 px-7 text-base text-purple-900 dark:text-purple-100 whitespace-nowrap font-semibold">
              <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400 font-bold">
                <span class="bg-purple-100 dark:bg-purple-900/50 p-2 rounded-xl">
                  <i class="fas fa-user text-purple-500 dark:text-purple-400 text-lg"></i>
                </span>
                <?= htmlspecialchars($user['name']); ?>
              </div>
            </td>
            <td class="py-5 px-7 text-base text-emerald-900 dark:text-emerald-100 whitespace-nowrap font-semibold">
              <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-bold">
                <span class="bg-emerald-100 dark:bg-emerald-900/50 p-2 rounded-xl">
                  <i class="fas fa-graduation-cap text-emerald-500 dark:text-emerald-400 text-lg"></i>
                </span>
                <?= htmlspecialchars($class['name']); ?>
              </div>
            </td>
            <td class="py-5 px-7 text-base whitespace-nowrap">
              <span class="bg-blue-100 dark:bg-blue-900/50 px-4 py-2 rounded-full text-blue-700 dark:text-blue-300 font-bold text-sm shadow-sm">
                <?= htmlspecialchars($schedule); ?>
              </span>
            </td>
            <td class="py-5 px-7 text-base whitespace-nowrap">
              <span class="bg-amber-100 dark:bg-amber-900/50 px-4 py-2 rounded-full text-amber-700 dark:text-amber-300 font-bold text-sm shadow-sm">
                <?= htmlspecialchars($date); ?>
              </span>
            </td>
          </tr>
      <?php
        }
      } else {
        echo '<tr><td colspan="5" class="py-16 px-7 text-center">
          <div class="flex flex-col items-center justify-center gap-4">
            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
              <i class="fas fa-calendar-times text-blue-500 dark:text-blue-400 text-2xl"></i>
            </div>
            <p class="text-blue-600 dark:text-blue-300 font-bold text-lg">Nenhum agendamento encontrado para hoje</p>
          </div>
        </td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>