<?php
$requiredRoles = ['funcionario', 'professor', 'pdt', 'gestao'];
require_once dirname(__DIR__) . '/src/bootstrap.php';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$type = isset($_GET['type']) ? (string) $_GET['type'] : null;
$time = isset($_GET['time']) ? (int) $_GET['time'] : null;
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agendaê</title>
  <link href="../../public/css/output.css" rel="stylesheet">
  <link rel="shortcut icon" href="../../public/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 text-slate-800 dark:text-white min-h-screen">

  <?php
  UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg');
  UI::renderAlerts(true);
  ?>

  <div class="container mx-auto px-4 py-6 lg:py-10">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 p-6 mb-8 shadow-lg transform transition-all duration-300 hover:shadow-xl">
      <div class="absolute top-0 left-0 w-full h-full bg-white/10 dark:bg-black/10"></div>
      <div class="absolute -right-12 -top-12 w-40 h-40 bg-white/20 dark:bg-white/5 rounded-full blur-2xl"></div>
      <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-white/20 dark:bg-white/5 rounded-full blur-2xl"></div>
      <div class="relative z-10 flex justify-between items-center">
        <div>
          <h1 class="text-4xl font-extrabold text-white mb-2">Agendaê</h1>
          <p class="text-emerald-50 text-lg max-w-lg">Gerencie seus agendamentos de equipamentos de forma simples e eficiente</p>
        </div>
        <button onclick="window.location.href='./agendar.php'" class="hidden md:flex items-center gap-2 bg-white text-emerald-600 hover:bg-emerald-50 font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
          <i class="fas fa-plus"></i>
          <span>Novo Agendamento</span>
        </button>
      </div>
    </div>

    <div class="mb-10">
      <button id="toggleMyBookings" class="w-full flex items-center justify-between bg-white dark:bg-slate-800 rounded-xl p-5 shadow-md hover:shadow-lg transition-all duration-300 group mb-2">
        <div class="flex items-center">
          <div class="flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mr-4">
            <i class="fas fa-calendar-check text-xl"></i>
          </div>
          <h2 class="text-xl font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Meus Agendamentos</h2>
        </div>
        <i id="bookingsIcon" class="fas fa-chevron-down text-emerald-500 transition-transform duration-300"></i>
      </button>

      <div id="myBookingsContent" class="overflow-hidden transition-all duration-500 max-h-0">
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-slate-100 dark:border-slate-700">
          <?php
          $currentUserBookings = $scheduleModel->get(['user_id' => $currentUser['id']]);
          if (empty($currentUserBookings)) { ?>
            <div class="flex flex-col items-center justify-center py-10 text-center">
              <div class="w-20 h-20 rounded-full bg-gradient-to-r from-emerald-500/10 to-teal-500/10 border-2 border-dashed border-emerald-300 dark:border-emerald-700 flex items-center justify-center mb-4">
                <i class="fas fa-calendar text-3xl text-emerald-400 dark:text-emerald-500"></i>
              </div>
              <h3 class="text-xl font-semibold mb-2 text-slate-700 dark:text-slate-200">Sem agendamentos</h3>
              <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-md">Você ainda não possui agendamentos. Que tal começar agora?</p>

              <button onclick="window.location.href='./agendar.php'" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium py-3 px-6 rounded-xl flex items-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>
                Criar Agendamento
              </button>
            </div>
          <?php } else { ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <?php $ui->renderBookings('../../', $currentUser['id'], true); ?>
            </div>
            <div class="mt-6 text-center">
              <button onclick="window.location.href='./agendar.php'" class="bg-emerald-100 dark:bg-emerald-900/30 hover:bg-emerald-200 dark:hover:bg-emerald-800/50 text-emerald-700 dark:text-emerald-400 font-medium py-2.5 px-5 rounded-lg flex items-center mx-auto transition-all duration-300">
                <i class="fas fa-plus mr-2"></i>
                Novo Agendamento
              </button>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>

    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl shadow-xl border border-slate-100/80 dark:border-slate-700/80 overflow-hidden">
      <div class="p-6 border-b border-slate-100 dark:border-slate-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
          <div class="flex items-center">
            <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mr-4">
              <i class="fas fa-laptop text-xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Equipamentos Disponíveis</h2>
          </div>

          <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative">
              <select id="typeFilter" class="appearance-none bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 rounded-xl pl-10 pr-10 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:focus:ring-emerald-600 shadow-sm transition-all">
                <option value="">Todos os tipos</option>
                <?php
                $query = "SHOW COLUMNS FROM equipments LIKE 'type'";
                $result = $conn->query($query);

                if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
                  $enumValues = str_replace(["enum(", ")", "'"], "", $row['Type']);
                  $values = explode(",", $enumValues);

                  foreach ($values as $value) {
                    echo '<option value="' . htmlspecialchars($value) . '">' . ucfirst(htmlspecialchars(Format::typeName($value))) . '</option>';
                  }
                }
                ?>
              </select>
              <div class="absolute left-3 top-2.5 text-emerald-500 dark:text-emerald-400">
                <i class="fas fa-filter"></i>
              </div>
              <div class="absolute right-3 top-2.5 text-slate-400 dark:text-slate-500 pointer-events-none">
                <i class="fas fa-chevron-down"></i>
              </div>
            </div>

            <div class="relative">
              <select id="timeFilter" class="appearance-none bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 rounded-xl pl-10 pr-10 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:focus:ring-emerald-600 shadow-sm transition-all">
                <option value="">Qualquer horário</option>
                <?php foreach (ScheduleModel::getTimeSlots() as $slot): ?>
                  <option value="<?php echo htmlspecialchars($slot['id']); ?>">
                    <?php echo sprintf(
                      '%s (%s - %s)',
                      htmlspecialchars($slot['name']),
                      htmlspecialchars($slot['start']),
                      htmlspecialchars($slot['end'])
                    ); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="absolute left-3 top-2.5 text-blue-500 dark:text-blue-400">
                <i class="fas fa-clock"></i>
              </div>
              <div class="absolute right-3 top-2.5 text-slate-400 dark:text-slate-500 pointer-events-none">
                <i class="fas fa-chevron-down"></i>
              </div>
            </div>

            <button id="toggleView" class="bg-slate-50 dark:bg-slate-700/50 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-medium py-2.5 px-5 rounded-xl flex items-center justify-center shadow-sm hover:shadow transition-all min-w-[120px]">
              <?php
              $isGridView = $currentUserPreferences['scheduleAppView'] === 'grid';
              $viewLabel = $isGridView ? 'Lista' : 'Grade';
              $viewIcon = $isGridView ? 'fa-list' : 'fa-th-large';
              ?>
              <i class="fas <?php echo $viewIcon; ?> mr-2"></i>
              <span><?php echo $viewLabel; ?></span>
            </button>

            <div class="relative">
              <input type="text" placeholder="Buscar equipamento..." class="bg-slate-50 dark:bg-slate-700/50 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-200 rounded-xl pl-10 pr-4 py-2.5 w-full focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:focus:ring-emerald-600 shadow-sm transition-all">
              <div class="absolute left-3 top-2.5 text-slate-400 dark:text-slate-500">
                <i class="fas fa-search"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-6">
        <?php $ui->renderEquipmentsAgendae($type, $currentUserPreferences['scheduleAppView'], $time, $page); ?>
      </div>

      <div class="flex justify-center p-6 border-t border-slate-100 dark:border-slate-700">
        <nav class="inline-flex rounded-xl shadow-sm" aria-label="Pagination">
          <a href="#" class="relative inline-flex items-center px-4 py-2 rounded-l-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
            <span class="sr-only">Anterior</span>
            <i class="fas fa-chevron-left"></i>
          </a>
          <span class="relative inline-flex items-center px-4 py-2 border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm font-medium text-slate-700 dark:text-slate-200">
            Página <?php echo $page; ?>
          </span>
          <a href="#" class="relative inline-flex items-center px-4 py-2 rounded-r-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-sm font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">
            <span class="sr-only">Próximo</span>
            <i class="fas fa-chevron-right"></i>
          </a>
        </nav>
      </div>
    </div>

    <div class="md:hidden fixed bottom-6 right-6 z-50">
      <button onclick="window.location.href='./agendar.php'" class="flex items-center justify-center w-14 h-14 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
        <i class="fas fa-plus text-xl"></i>
      </button>
    </div>
  </div>

  <?php UI::renderFooter('../'); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('toggleMyBookings');
      const content = document.getElementById('myBookingsContent');
      const icon = document.getElementById('bookingsIcon');
      let isOpen = false;

      function toggleSection() {
        if (isOpen) {
          content.style.maxHeight = '0';
          icon.classList.remove('fa-chevron-up');
          icon.classList.add('fa-chevron-down');
        } else {
          content.style.maxHeight = content.scrollHeight + 'px';
          icon.classList.remove('fa-chevron-down');
          icon.classList.add('fa-chevron-up');
        }
        isOpen = !isOpen;
      }

      toggleBtn.addEventListener('click', toggleSection);

      document.getElementById('toggleView').addEventListener('click', function() {
        fetch('../src/controllers/user/preferences/scheduleAppView.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.text())
          .then(() => {
            location.reload();
          })
          .catch(error => console.error('Erro:', error));
      });

      const typeSelect = document.getElementById('typeFilter');
      const timeSelect = document.getElementById('timeFilter');
      typeSelect.addEventListener('change', updateURLParameters);
      timeSelect.addEventListener('change', updateURLParameters);

      setSelectsFromURL();

      function updateURLParameters() {
        const typeValue = typeSelect.value;
        const timeValue = timeSelect.value;

        let url = window.location.pathname;

        const params = new URLSearchParams(window.location.search);

        if (typeValue) {
          params.set('type', typeValue);
        } else {
          params.delete('type');
        }

        if (timeValue) {
          params.set('time', timeValue);
        } else {
          params.delete('time');
        }

        const queryString = params.toString();
        if (queryString) {
          url += '?' + queryString;
        }

        window.location.href = url;
      }

      function setSelectsFromURL() {
        const params = new URLSearchParams(window.location.search);

        if (params.has('type')) {
          typeSelect.value = params.get('type');
        }

        if (params.has('time')) {
          timeSelect.value = params.get('time');
        }
      }
    });
  </script>

  <script src="../../public/js/agendae/searchBarController.js"></script>
  <?php $viewScript = $currentUserPreferences['scheduleAppView'] === 'grid' ? 'searchBarGridView.js' : 'searchBarListView.js'; ?>
  <script src="../../public/js/agendae/<?php echo htmlspecialchars($viewScript); ?>"></script>
</body>

</html>