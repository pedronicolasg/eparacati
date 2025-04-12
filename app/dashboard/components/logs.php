<?php
$recentLogs = $logger->getLogs();
$recentLogs = array_slice($recentLogs, 0, 3);

if (empty($recentLogs)) {
  echo '<p class="text-gray-500 dark:text-gray-400 text-sm">Nenhum registro encontrado.</p>';
} else {
  foreach ($recentLogs as $log) {
    $icon = 'fa-bell';
    $color = 'blue';

    switch ($log['action']) {
      case 'add':
        $icon = 'fa-plus';
        $color = 'green';
        break;
      case 'edit':
        $icon = 'fa-pen';
        $color = 'blue';
        break;
      case 'delete':
        $icon = 'fa-trash';
        $color = 'red';
        break;
      case 'login':
        $icon = 'fa-sign-in-alt';
        $color = 'purple';
        break;
      case 'logout':
        $icon = 'fa-sign-out-alt';
        $color = 'gray';
        break;
    }

    $title = Format::actionName($log['action']);
    if (!empty($log['target_table'])) {
      $title .= ' - ' . Format::tableName($log['target_table']);
    }

    $message = !empty($log['message']) ? $log['message'] : 'Sem detalhes adicionais';
?>
    <div class="bg-gray-50 dark:bg-slate-700 rounded p-3 border-l-4 border-<?php echo $color; ?>-500 mb-3">
      <div class="flex items-start">
        <div class="bg-<?php echo $color; ?>-100 dark:bg-<?php echo $color; ?>-900 p-2 rounded-full mr-3 flex-shrink-0">
          <i class="fas <?php echo $icon; ?> text-<?php echo $color; ?>-500 dark:text-<?php echo $color; ?>-400 text-sm"></i>
        </div>
        <div>
          <p class="font-medium text-gray-900 dark:text-white text-sm"><?php echo htmlspecialchars($title); ?></p>
          <p class="text-gray-600 dark:text-gray-400 text-xs mt-1"><?php echo htmlspecialchars($message); ?></p>
          <p class="text-gray-500 dark:text-gray-500 text-xs mt-1"><?php echo htmlspecialchars($log['timestamp']); ?></p>
        </div>
      </div>
    </div>
<?php
  }
}
?>