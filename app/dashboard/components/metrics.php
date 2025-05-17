<div class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-blue-900/20 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
  <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full -mr-8 -mt-8 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="absolute bottom-0 left-0 w-16 h-16 bg-blue-500/10 rounded-full -ml-6 -mb-6 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="flex justify-between items-start relative z-10">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Avisos Criados/Ativos</p>
      <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 flex items-end">0 <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 font-normal">total</span></h3>
      <a href="../../indev.php" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
        <i class="fas fa-bullhorn mr-2"></i>
        Gerenciar
      </a>
    </div>
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-md">
      <i class="fas fa-bullhorn text-white text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-gradient-to-br from-white to-green-50 dark:from-gray-800 dark:to-green-900/20 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
  <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/10 rounded-full -mr-8 -mt-8 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="absolute bottom-0 left-0 w-16 h-16 bg-green-500/10 rounded-full -ml-6 -mb-6 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="flex justify-between items-start relative z-10">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Turmas Registradas</p>
      <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 flex items-end"><?= $classModel->count()['total']; ?> <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 font-normal">turmas</span></h3>
      <a href="pages/turmas.php" class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
        <i class="fas fa-graduation-cap mr-2"></i>
        Gerenciar
      </a>
    </div>
    <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-xl shadow-md">
      <i class="fas fa-graduation-cap text-white text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-gradient-to-br from-white to-purple-50 dark:from-gray-800 dark:to-purple-900/20 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
  <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full -mr-8 -mt-8 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="absolute bottom-0 left-0 w-16 h-16 bg-purple-500/10 rounded-full -ml-6 -mb-6 transition-transform duration-300 group-hover:scale-110"></div>
  <div class="flex justify-between items-start relative z-10">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Usuários Cadastrados</p>
      <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 flex items-end"><?= $userModel->count(); ?> <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 font-normal">usuários</span></h3>
      <a href="pages/usuarios.php" class="mt-4 inline-flex items-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
        <i class="fas fa-users mr-2"></i>
        Gerenciar
      </a>
    </div>
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl shadow-md">
      <i class="fas fa-users text-white text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-gradient-to-br from-white to-cyan-50 dark:from-gray-800 dark:to-cyan-900/20 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
  <div class="absolute top-0 right-0 w-24 h-24 bg-cyan-500/10 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-300"></div>
  <div class="absolute bottom-0 left-0 w-16 h-16 bg-cyan-500/10 rounded-full -ml-6 -mb-6 group-hover:scale-110 transition-transform duration-300"></div>
  <div class="flex justify-between items-start relative z-10">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Equipamentos Cadastrados</p>
      <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 flex items-end"><?= $equipmentModel->count(); ?> <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 font-normal">itens</span></h3>
      <a href="pages/equipamentos.php" class="mt-4 inline-flex items-center px-4 py-2 bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
        <i class="fas fa-desktop mr-2"></i>
        Gerenciar
      </a>
    </div>
    <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-4 rounded-xl shadow-md">
      <i class="fas fa-desktop text-white text-xl"></i>
    </div>
  </div>
</div>

<div class="bg-gradient-to-br from-white to-amber-50 dark:from-gray-800 dark:to-amber-900/20 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 group relative overflow-hidden">
  <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-300"></div>
  <div class="absolute bottom-0 left-0 w-16 h-16 bg-amber-500/10 rounded-full -ml-6 -mb-6 group-hover:scale-110 transition-transform duration-300"></div>
  <div class="flex justify-between items-start relative z-10">
    <div>
      <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Agendamentos Ativos</p>
      <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2 flex items-end"><?= $scheduleModel->count(); ?> <span class="text-sm text-gray-500 dark:text-gray-400 ml-2 font-normal">agendamentos</span></h3>
      <a href="pages/agendamentos.php" class="mt-4 inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow">
        <i class="fa-solid fa-clipboard-list mr-2"></i>
        Gerenciar
      </a>
    </div>
    <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-4 rounded-xl shadow-md">
      <i class="fa-solid fa-clipboard-list text-white text-xl"></i>
    </div>
  </div>
</div>