<div class="bg-white dark:bg-slate-800 rounded-lg p-5 border-t-4 border-blue-500 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
  <div class="flex justify-between items-start">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm">Avisos Ativos</p>
      <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">XX</h3>
      <a href="../../indev.php" class="font-bold text-blue-500 hover:text-blue-600 dark:text-blue-400 dark:hover:text-blue-300 text-sm mt-2 inline-block hover:underline">Gerenciar Avisos</a>
    </div>
    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
      <i class="fas fa-bullhorn text-blue-500 dark:text-blue-400 text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-lg p-5 border-t-4 border-green-500 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
  <div class="flex justify-between items-start">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm">Turmas Registradas</p>
      <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"><?= $classController->count(); ?></h3>
      <a href="pages/turmas.php" class="font-bold text-green-500 hover:text-green-600 dark:text-green-400 dark:hover:text-green-300 text-sm mt-2 inline-block hover:underline">Gerenciar Turmas</a>
    </div>
    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
      <i class="fas fa-graduation-cap text-green-500 dark:text-green-400 text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-lg p-5 border-t-4 border-purple-500 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
  <div class="flex justify-between items-start">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm">Usuários Cadastrados</p>
      <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"><?= $userController->count(); ?></h3>
      <a href="pages/usuarios.php" class="font-bold text-purple-500 hover:text-purple-600 dark:text-purple-400 dark:hover:text-purple-300 text-sm mt-2 inline-block hover:underline">Gerenciar Usuários</a>
    </div>
    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
      <i class="fas fa-users text-purple-500 dark:text-purple-400 text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-lg p-5 border-t-4 border-cyan-500 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-1">
  <div class="flex justify-between items-start">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm">Equipamentos Cadastrados</p>
      <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1"><?= $equipmentController->count(); ?></h3>
      <a href="pages/equipamentos.php" class="font-bold text-cyan-500 hover:text-cyan-600 dark:text-cyan-400 dark:hover:text-cyan-300 text-sm mt-2 inline-block hover:underline">Gerenciar Equipamentos</a>
    </div>
    <div class="bg-cyan-100 dark:bg-cyan-900 p-3 rounded-full">
      <i class="fas fa-desktop text-cyan-500 dark:text-cyan-400 text-xl"></i>
    </div>
  </div>
</div>