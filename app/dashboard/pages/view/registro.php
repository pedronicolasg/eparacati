<?php $UI = new UI(); ?>

<div class="container mx-auto px-4 py-8">
  <?php
  echo $UI->renderLogDetail($currentLog);
  ?>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-2">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
          <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Mudanças</h3>
        </div>
        <div class="p-6">
          <?php
          if ($currentLog['action'] === 'update') {
          ?>
            <div class="mb-6">
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Campos afetados</h4>
              <div class="space-y-4">
                <?php echo $UI->formatLogChangesToHtml($currentLog); ?>
              </div>
            </div>
          <?php
          }
          ?>

          <div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Mensagem bruta</h4>
            <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-md overflow-x-auto">
              <pre class="text-xs text-gray-800 dark:text-gray-300 whitespace-pre-wrap"><?php echo htmlspecialchars($currentLog['message']); ?></pre>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
          <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Registros relacionados</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data & Hora</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuário</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ação</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sumário</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              <?php
              $logs = $logger->getLogs(['target_id' => $currentLog['target_id']]);

              foreach ($logs as $log) {
                $log = array_map('htmlspecialchars', $log);
                $log['user_name'] = strlen($log['user_name']) > 11 ? substr($log['user_name'], 0, 11) . '...' : $log['user_name'];
                $log['message'] = strlen($log['message']) > 30 ? substr($log['message'], 0, 30) . '...' : $log['message'];
              ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-[#2a323c] border-b border-gray-200 dark:border-gray-700/50">
                  <?php if ($log['id'] == $currentLog['id']) { ?>
                <tr class="bg-blue-50 dark:bg-blue-900/20">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 dark:text-blue-400"><?= $currentLog['id'] ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= $currentLog['timestamp'] ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= $currentLog['user_name'] ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= Format::actionName($currentLog['action']) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">Registro atual</td>
                </tr>
              <?php } else { ?>
                <tr class="hover:bg-gray-100 dark:hover:bg-[#2a323c] border-b border-gray-200 dark:border-gray-700/50 cursor-pointer" onclick="window.location.href='./registros.php?id=<?= Security::hide($log['id']) ?>'">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 dark:text-blue-400"><?= $log['id'] ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">[ <?= $log['timestamp'] ?> ]</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= $log['user_name'] ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= Format::actionName($log['action']) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?= $log['message'] ?></td>
                </tr>
            <?php }
                } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="md:col-span-1">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
          <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Metadados</h3>
        </div>
        <div class="p-6">
          <dl class="space-y-4">
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID do usuário</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= $currentLog['user_id'] ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuário</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= $currentLog['user_name'] ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ação</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= Format::actionName($currentLog['action']) ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Área afetada</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= Format::tableName($currentLog['target_table']) ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID do Alvo</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= $currentLog['target_id'] ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Endereço IP</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200"><?= $currentLog['ip_address'] ?></dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Data & Hora</dt>
              <dd class="mt-1 text-sm text-gray-800 dark:text-gray-200">[ <?= $currentLog['timestamp'] ?> ]</dd>
            </div>
          </dl>
        </div>
      </div>

      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
          <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Ações</h3>
        </div>
        <div class="p-6">
          <div class="space-y-3">
            <button id="copyIdButton" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 rounded-md text-white text-sm font-medium flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              Copiar ID do registro
            </button>
            <button onclick="exportLogAsExcel(<?= $currentLog['id'] ?>)" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-700 rounded-md text-white text-sm font-medium flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Exportar registro (Excel)
            </button>
            <button onclick="exportLogAsJSON(<?= $currentLog['id'] ?>)" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 dark:bg-yellow-600 dark:hover:bg-yellow-700 rounded-md text-white text-sm font-medium flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Exportar registro (JSON)
            </button>
            <button onclick="deleteLog(<?= $currentLog['id'] ?>)" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-md text-white text-sm font-medium flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Excluir registro
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>