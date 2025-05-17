<section class="mb-12">
  <div class="flex items-center mb-6 gap-3">
    <div class="h-10 w-2 bg-gradient-to-b from-blue-600 via-purple-600 to-pink-500 rounded-full"></div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Métricas Principais</h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
    <?php include_once 'components/metrics.php'; ?>
  </div>
</section>
<section class="mb-12">
  <div class="flex items-center mb-6 gap-3">
    <div class="h-10 w-2 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Aplicativos</h2>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    <?php include_once 'components/apps.php'; ?>
  </div>
</section>
<section class="mb-12">
  <div class="bg-white/90 dark:bg-gray-900/80 rounded-3xl overflow-hidden shadow-xl border border-gray-200/80 dark:border-gray-700/80 backdrop-blur-md">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
      <div class="flex items-center gap-3">
        <i class="fas fa-calendar-check text-blue-500 dark:text-blue-400 text-2xl"></i>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Próximas Reservas de Equipamentos</h2>
      </div>
      <a href="pages/agendamentos.php" class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl flex items-center text-base font-semibold shadow-md hover:shadow-lg transition-all duration-200 gap-2">
        <span>Ver Todas</span>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
    <div class="overflow-x-auto">
      <?php include_once 'components/bookings.php'; ?>
    </div>
  </div>
</section>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
  <section class="lg:col-span-2">
    <div class="flex items-center mb-6 gap-3">
      <div class="h-10 w-2 bg-gradient-to-b from-amber-500 to-orange-600 rounded-full"></div>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Ações Rápidas</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <?php include_once 'components/actions.php'; ?>
    </div>
  </section>
  <section class="lg:col-span-1">
    <div class="bg-white/90 dark:bg-gray-900/80 rounded-3xl h-full shadow-xl border border-gray-200/80 dark:border-gray-700/80 backdrop-blur-md">
      <div class="flex justify-between items-center p-6 rounded-t-3xl border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
        <div class="flex items-center gap-3">
          <i class="fas fa-history text-purple-500 dark:text-purple-400 text-2xl"></i>
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">Registros Recentes</h2>
        </div>
        <a href="pages/registros.php" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-xl flex items-center text-base font-semibold shadow-md hover:shadow-lg transition-all duration-200 gap-2">
          <span>Ver Todos</span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <div class="p-6">
        <div class="space-y-6">
          <?php include_once 'components/logs.php'; ?>
        </div>
      </div>
    </div>
  </section>
</div>