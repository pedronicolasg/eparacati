<?php
$recentLogs = $logger->getLogs();
$recentLogs = array_slice($recentLogs, 0, 4);

if (empty($recentLogs)) {
  echo '<div class="flex flex-col items-center justify-center py-8 px-4">
          <div class="bg-purple-100/80 dark:bg-purple-900/30 p-3 rounded-full mb-3">
            <i class="fas fa-history text-purple-400 dark:text-purple-300 text-xl"></i>
          </div>
          <p class="text-purple-600 dark:text-purple-200 text-base font-medium text-center">Nenhum registro encontrado</p>
        </div>';
} else {
  foreach ($recentLogs as $log) {
    $icon = 'fa-bell';
    $color = 'blue';
    switch ($log['action']) {
      case 'add':
        $icon = 'fa-plus';
        $color = 'emerald';
        break;
      case 'setup':
        $icon = 'fa-cogs';
        $color = 'teal';
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
      case 'book':
        $icon = 'fa-book';
        $color = 'yellow';
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
    $messageShort = strlen($message) > 80 ? substr($message, 0, 80) . '...' : $message;
    $logId = 'log-' . uniqid();
?>
    <a href="./pages/registros.php?id=<?php echo Security::hide($log['id']); ?>" class="block">
      <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow transition-all duration-300 hover:-translate-y-2 mb-3 overflow-hidden border-l-4 border-<?php echo $color; ?>-500 dark:border-<?php echo $color; ?>-600 group">
        <div class="flex items-center p-3 gap-3">
          <div class="bg-<?php echo $color; ?>-100 dark:bg-<?php echo $color; ?>-900/30 p-2 rounded-lg">
            <i class="fas <?php echo $icon; ?> text-<?php echo $color; ?>-500 dark:text-<?php echo $color; ?>-400"></i>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex flex-wrap justify-between items-center gap-2">
              <p class="font-bold text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($title); ?></p>
              <span class="text-<?php echo $color; ?>-600 dark:text-<?php echo $color; ?>-400 text-xs font-medium"><?php echo substr(Format::date($log['timestamp']), 0, 10); ?></span>
            </div>
            <div class="mt-1">
              <p id="<?php echo $logId; ?>-short" class="text-gray-600 dark:text-gray-300 text-xs"><?php echo htmlspecialchars($messageShort); ?></p>
              <?php if (strlen($message) > 80): ?>
                <p id="<?php echo $logId; ?>-full" class="hidden text-gray-600 dark:text-gray-300 text-xs"><?php echo htmlspecialchars($message); ?></p>
                <button onclick="toggleMessage('<?php echo $logId; ?>')" id="<?php echo $logId; ?>-btn" class="text-<?php echo $color; ?>-500 hover:text-<?php echo $color; ?>-700 text-xs mt-1 font-medium">Ver mais</button>
              <?php endif; ?>
              <p class="text-gray-400 dark:text-gray-500 text-xs mt-1"><?php echo htmlspecialchars(Format::date($log['timestamp'])); ?></p>
            </div>
          </div>
        </div>
      </div>
    </a>
<?php
  }
}

?>