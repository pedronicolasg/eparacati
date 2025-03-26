<?php
$requiredRoles = ['funcionario', 'professor', 'gestao'];
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
  <link rel="stylesheet" href="../../public/assets/css/style.css">
  <link rel="shortcut icon" href="../../public/assets/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body
  class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-white min-h-screen">

  <?php UI::renderNavbar($currentUser, '../', '', 'green', 'logo.svg'); ?>

  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center">
        <h1 class="text-3xl font-bold bg-gradient-to-r from-green-500 to-green-700 bg-clip-text text-transparent">Agendaê</h1>
      </div>
    </div>
    <h2 class="text-xl font-bold mb-4 flex items-center">
      <i class="fas fa-calendar-check mr-2 text-green-500"></i>
      Meus Agendamentos
    </h2>


    <div class="relative bg-white dark:bg-gray-800 rounded-xl p-8 mb-8 shadow-md overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-blue-500/5"></div>
      <div class="relative flex flex-col items-center justify-center py-10">
        <?php
        $currentUserBookings = $scheduleController->get(['user_id' => $currentUser['id']]);
        if (empty($currentUserBookings)) { ?>
          <div
            class="w-16 h-16 rounded-full bg-gradient-to-r from-green-500/10 to-blue-500/10 border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center mb-4">
            <i class="fas fa-plus text-2xl text-gray-500 dark:text-gray-400"></i>
          </div>
          <h2 class="text-xl font-semibold mb-2">Sem agendamentos</h2>
          <p class="text-gray-600 dark:text-gray-400 mb-6">Comece criando um novo agendamento.</p>

          <button onclick="window.location.href='./agendar.php'"
            class="dropdown-toggle bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-2.5 px-5 rounded-lg flex items-center shadow-md hover:shadow-lg transition-all">
            <i class="fas fa-plus mr-2"></i>
            Agendar
          </button>
        <?php } else {
          echo '      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';
          $ui->renderCurrentUserBookings($scheduleController, $currentUser['id']);
          echo '</div>';
        } ?>
      </div>
    </div>


    <div>
      <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <h2 class="text-xl font-bold flex items-center">
          <i class="fas fa-list-ul mr-2 text-blue-500"></i>
          Lista de Equipamentos
        </h2>

        <div class="flex flex-col sm:flex-row gap-3">
          <select
            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
            <option value="">Todos</option>
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

          <select
            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
            <option value="">Agora</option>
            <?php foreach (ScheduleController::getTimeSlots() as $slot): ?>
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

          <div class="relative">
            <input type="text" placeholder="Buscar equipamento..."
              class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg pl-10 pr-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
            <div class="absolute left-3 top-2.5 text-gray-500 dark:text-gray-400">
              <i class="fas fa-search"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $ui->renderEquipmentsAgendae($conn, $type, $time, $page) ?>
      </div>

      <div class="flex justify-center mt-8">
        <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <a href="#"
            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
            <span class="sr-only">Anterior</span>
            <i class="fas fa-chevron-left"></i>
          </a>

          <a href="#"
            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
            <span class="sr-only">Próximo</span>
            <i class="fas fa-chevron-right"></i>
          </a>
        </nav>
      </div>
    </div>
  </div>

  <?php UI::renderFooter('../'); ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const typeSelect = document.querySelector('select:nth-of-type(1)');
      const timeSelect = document.querySelector('select:nth-of-type(2)');
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
  <script src="../../public/assets/js/agendae/searchbar.js"></script>
</body>

</html>