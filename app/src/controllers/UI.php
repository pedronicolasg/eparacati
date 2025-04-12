<?php
require_once 'core/conn.php';

require_once 'controllers/User.php';
require_once 'controllers/Equipment.php';
require_once 'controllers/Schedule.php';

class UI
{
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  // Funções de renderização estáticas
  public static function renderNavbar($currentUser, $basePath, $activePage = "Home", $color = "green", $logo = "logo.svg")
  {
    $links = [
      "Home" => "{$basePath}index.php",
      "Conexão Acadêmica" => "{$basePath}indev.php",
      "Dashboard" => "{$basePath}dashboard/",
    ];

    $handlersPath = "{$basePath}../app/src/handlers";
    $assetsPath = "{$basePath}../public/assets";
    $profilePath = "{$basePath}perfil.php";
?>
    <div class="h-1 bg-gradient-to-r from-green-400 via-purple-500 to-blue-500 animate-gradient bg-[length:200%_auto]"></div>
    <nav class="bg-white/80 backdrop-blur-sm border-b border-gray-200/80 dark:bg-gray-900/80 dark:border-gray-800/80 sticky top-0 z-50 transition-all duration-300 ease-in-out">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex-shrink-0 flex items-center">
            <a href="#" class="flex items-center">
              <img src="<?php echo $assetsPath; ?>/images/<?php echo $logo; ?>" class="h-8" alt="EP Aracati Logo" />
              <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white">EP Aracati</span>
            </a>
          </div>

          <div class="flex items-center sm:hidden">
            <button id="mobile-menu-button" type="button"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
              <span class="sr-only">Abrir menu</span>
              <svg id="menu-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg id="close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="hidden sm:flex sm:items-center sm:justify-center flex-1 mx-4">
            <div class="flex space-x-2">
              <?php foreach ($links as $name => $url): ?>
                <a href="<?php echo $url; ?>"
                  class="px-4 py-2 <?php echo $name === $activePage
                                      ? "text-" . $color . "-600 font-medium transition-colors duration-200 dark:text-" . $color . "-500"
                                      : "text-gray-700 hover:text-" . $color . "-600 transition-colors duration-200 dark:text-gray-200 dark:hover:text-" . $color . "-500"; ?>">
                  <?php echo $name; ?>
                </a>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="hidden sm:flex sm:items-center">
            <div class="relative">
              <button id="user-menu-button" type="button"
                class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-800"
                aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm"
                  src="<?php echo $currentUser["profile_photo"]; ?>" alt="Foto do usuário">
              </button>

              <div id="user-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700 focus:outline-none z-10 transition-all duration-300 ease-in-out opacity-0 scale-95 transform">
                <div class="px-4 py-3">
                  <p class="text-sm font-medium text-gray-900 dark:text-white"><?= $currentUser["name"]; ?></p>
                  <p class="text-sm text-<?= $color ?>-600 dark:text-<?= $color ?>-400 truncate">
                    <?= $currentUser["email"]; ?></p>
                </div>
                <div class="py-1">
                  <a href="<?php echo $profilePath; ?>"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-150">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Meu perfil
                  </a>
                  <button type="button" onclick="toggleTheme('<?= $handlersPath ?>/user/preferences/theme.php')"
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-150 text-left">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    Alternar tema
                  </button>
                  <a href="<?php echo $handlersPath; ?>/user/logout.php"
                    class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:text-red-600 dark:hover:bg-gray-700 transition-colors duration-150">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sair
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="mobile-menu" class="hidden sm:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <?php foreach ($links as $name => $url): ?>
            <a href="<?php echo $url; ?>"
              class="block px-3 py-2 rounded-md text-base font-medium <?php echo $name === $activePage
                                                                        ? "text-" . $color . "-600 bg-gray-50 dark:bg-gray-700 dark:text-white"
                                                                        : "text-gray-700 hover:text-" . $color . "-600 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"; ?>">
              <?php echo $name; ?>
            </a>
          <?php endforeach; ?>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <img class="h-10 w-10 rounded-full object-cover" src="<?php echo $currentUser["profile_photo"]; ?>"
                alt="Foto do usuário">
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800 dark:text-white"><?= $currentUser["name"]; ?></div>
              <div class="text-sm font-medium text-<?= $color ?>-600 dark:text-<?= $color ?>-400">
                <?= $currentUser["email"]; ?></div>
            </div>
          </div>
          <div class="mt-3 px-2 space-y-1">
            <a href="#"
              class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">Meu
              perfil</a>
            <button type="button" onclick="toggleTheme('<?= $handlersPath ?>/user/preferences/theme.php')"
              class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">
              Alternar tema
            </button>
            <a href="<?php echo $handlersPath; ?>/user/logout.php"
              class="block px-3 py-2 rounded-md text-base font-medium text-red-700 hover:text-primary hover:bg-gray-50 dark:text-red-600 dark:hover:bg-gray-700">Sair</a>
          </div>
        </div>
      </div>
    </nav>
    <script src="<?php echo $assetsPath; ?>/js/navbar.js"></script>

  <?php
  }

  public static function renderPopup($alertas = null)
  {
    if (!is_array($alertas)) {
      $alertas = [];

      if (isset($_SESSION['alert'])) {
        if (is_array($_SESSION['alert'])) {
          $alertas = $_SESSION['alert'];
        } else {
          $alertas[] = $_SESSION['alert'];
        }
        unset($_SESSION['alert']);
      }
    }

    if (empty($alertas)) return;

    $colors = [
      'info' => 'blue',
      'error' => 'red',
      'success' => 'green',
      'warning' => 'yellow'
    ];

    $alertCount = [];
    foreach ($alertas as $alert) {
      $key = ($alert['titulo'] ?? '') . '|' . ($alert['mensagem'] ?? '') . '|' . ($alert['tipo'] ?? 'info');
      $alertCount[$key] = isset($alertCount[$key]) ? $alertCount[$key] + 1 : 1;
    }

    $processedAlertas = [];
    $processedKeys = [];
    foreach ($alertas as $alert) {
      $titulo = $alert['titulo'] ?? null;
      $mensagem = $alert['mensagem'] ?? null;
      $tipo = $alert['tipo'] ?? 'info';

      if (!$titulo || !$mensagem) continue;

      $key = $titulo . '|' . $mensagem . '|' . $tipo;

      if (!in_array($key, $processedKeys)) {
        $count = $alertCount[$key];
        if ($count > 1) {
          $alert['titulo'] = $titulo . " ({$count}x)";
        }
        $processedAlertas[] = $alert;
        $processedKeys[] = $key;
      }
    }

    $popupContainer = uniqid('popup-container-');
  ?>
    <div id="<?= $popupContainer ?>" class="fixed inset-0 z-[9999] flex flex-col items-end justify-end p-4 gap-3"></div>
    <script>
      const alertsQueue = <?= json_encode($processedAlertas) ?>;
      const popupContainer = document.getElementById('<?= $popupContainer ?>');
      const maxVisibleAlerts = 5;
      let activeAlerts = 0;

      const colors = <?= json_encode($colors) ?>;

      function showAlert(alert) {
        if (activeAlerts >= maxVisibleAlerts) return false;

        const titulo = alert.titulo || '';
        const mensagem = alert.mensagem || '';
        const tipo = alert.tipo || 'info';
        const color = colors[tipo] || 'blue';

        const alertId = 'alert-' + Math.random().toString(36).substr(2, 9);

        const alertElement = document.createElement('div');
        alertElement.id = alertId;
        alertElement.className = `relative w-full max-w-md rounded-xl bg-white dark:bg-gray-800 shadow-xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.68,-0.6,0.32,1.6)] transform translate-x-full opacity-0`;
        alertElement.setAttribute('role', 'alert');

        alertElement.innerHTML = `
          <div class="absolute top-0 left-0 w-1 h-full bg-${color}-500"></div>
          <div class="p-4 pl-5 flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-${color}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div class="ml-3 flex-1 pt-0.5">
              <h3 class="text-sm font-medium text-gray-900 dark:text-white">${titulo}</h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${mensagem}</p>
            </div>
            <button 
              type="button" 
              class="ml-4 flex-shrink-0 rounded-md inline-flex text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-${color}-500"
              onclick="closeAlert('${alertId}')"
              aria-label="Close">
              <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        `;

        popupContainer.appendChild(alertElement);
        activeAlerts++;

        setTimeout(() => {
          const alert = document.getElementById(alertId);
          if (alert) alert.classList.remove('translate-x-full', 'opacity-0');
        }, 100);

        setTimeout(() => {
          closeAlert(alertId);
        }, 10000);

        return true;
      }

      function closeAlert(alertId) {
        const alert = document.getElementById(alertId);
        if (!alert) return;

        alert.classList.add('translate-x-full', 'opacity-0');

        setTimeout(() => {
          try {
            alert.remove();
            activeAlerts--;

            checkQueue();

            if (!popupContainer.hasChildNodes()) {
              popupContainer.remove();
            }
          } catch (e) {
            console.error('Error removing alert:', e);
          }
        }, 500);
      }

      document.addEventListener('click', function(e) {
        const closeButton = e.target.closest('button[aria-label="Close"]');
        if (closeButton) {
          const alertId = closeButton.closest('div[role="alert"]').id;
          if (alertId) {
            closeAlert(alertId);
            e.preventDefault();
            e.stopPropagation();
          }
        }
      });

      function checkQueue() {
        if (alertsQueue.length > 0 && activeAlerts < maxVisibleAlerts) {
          const nextAlert = alertsQueue.shift();
          if (showAlert(nextAlert)) {
            setTimeout(checkQueue, 100);
          }
        }
      }

      checkQueue();
    </script>
  <?php
  }

  public static function renderHeader($basePath, $carouselItems, $newsItems)
  {
  ?>

    <style>
      .carousel-slide {
        transition: transform 0.3s ease-in-out;
      }
    </style>

    <div class="max-w-7xl mx-auto px-4 py-8">
      <header class="mb-8">
        <h1 class="text-lg font-medium text-gray-500 uppercase tracking-wide dark:text-gray-400">
          Importante
        </h1>
      </header>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
          <div class="relative overflow-hidden rounded-xl" id="carousel">
            <div class="flex transition-transform duration-300 ease-in-out" id="carousel-container">
              <?php foreach ($carouselItems as $item): ?>
                <div class="flex-[0_0_100%] min-w-0">
                  <div class="relative">
                    <img src="<?php echo htmlspecialchars(
                                $item["image"]
                              ); ?>" class="w-full h-[400px] object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                      <h2 class="text-white text-2xl font-semibold">
                        <?php echo htmlspecialchars($item["text"]); ?>
                      </h2>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <button onclick="moveSlide(-1)"
              class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full shadow-lg hover:bg-white dark:bg-gray-900 dark:hover:bg-gray-950 transition-colors"
              aria-label="Previous slide">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
              </svg>
            </button>
            <button onclick="moveSlide(1)"
              class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 p-2 rounded-full shadow-lg hover:bg-white dark:bg-gray-900 dark:hover:bg-gray-950  transition-colors"
              aria-label="Next slide">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
              </svg>
            </button>
          </div>
        </div>

        <div class="lg:col-span-1">
          <div class="border-l-4 border-green-500 pl-4 mb-6">
            <h2 class="text-sm font-semibold text-green-600 uppercase tracking-wide">
              Últimos informes
            </h2>
          </div>

          <div class="space-y-6">
            <?php foreach ($newsItems as $item): ?>
              <article>
                <span class="text-xs font-semibold text-green-600 uppercase tracking-wide">
                  <?php echo htmlspecialchars($item["category"]); ?>
                </span>
                <h3 class="mt-2 text-xl font-semibold hover:text-emerald-600 transition-colors">
                  <?php echo htmlspecialchars($item["title"]); ?>
                </h3>
              </article>
            <?php endforeach; ?>

            <div class="pt-4">
              <button class="text-green-600 hover:text-green-700 font-medium flex items-center gap-2">
                Ver mais
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="m9 18 6-6-6-6" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      const carousel = document.getElementById('carousel-container');
      let currentSlide = 0;
      const totalSlides = <?php echo count($carouselItems); ?>;

      function moveSlide(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
      }

      let autoplayInterval;

      function startAutoplay() {
        autoplayInterval = setInterval(() => {
          moveSlide(1);
        }, 5000);
      }

      function stopAutoplay() {
        clearInterval(autoplayInterval);
      }

      startAutoplay();

      carousel.addEventListener('mouseenter', stopAutoplay);
      carousel.addEventListener('mouseleave', startAutoplay);
    </script>
  <?php
  }

  public static function renderFooter($basePath)
  {
    $assetsPath = $basePath . "../public/assets";
  ?>
    <div class="h-1 bg-gradient-to-r from-green-400 via-purple-500 to-blue-500 animate-gradient bg-[length:200%_auto]"></div>
    <footer class="bg-white/80 backdrop-blur-sm dark:bg-gray-900/80 border-t border-gray-200/80 dark:border-gray-800/80">
      <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="col-span-1 lg:col-span-2">
            <a href="<?php echo $basePath; ?>index.php" class="flex items-center mb-4 sm:mb-0 group">
              <img src="<?php echo $assetsPath; ?>/images/logo.svg" class="h-10 me-3 transition-transform duration-300 group-hover:scale-110" alt="EP Aracati Logo" />
              <div>
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">EP Aracati</span>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 max-w-md">Educação de qualidade e formação profissional para um futuro brilhante.</p>
              </div>
            </a>
          </div>
          <div>
            <h2 class="mb-4 text-sm font-semibold text-gray-900 uppercase dark:text-white relative inline-block">
              Legal
              <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-green-400 to-blue-500 transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></span>
            </h2>
            <ul class="text-gray-600 dark:text-gray-400 font-medium space-y-4">
              <li>
                <a href="https://www.instagram.com/eparacati/" class="hover:text-green-500 dark:hover:text-green-400 transition-colors duration-300 flex items-center gap-2">
                  <span class="w-1 h-1 rounded-full bg-green-500"></span>
                  Política de privacidade
                </a>
              </li>
              <li>
                <a href="https://www.instagram.com/gremioadolfocaminha/" class="hover:text-green-500 dark:hover:text-green-400 transition-colors duration-300 flex items-center gap-2">
                  <span class="w-1 h-1 rounded-full bg-green-500"></span>
                  Termos e serviços
                </a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-4 text-sm font-semibold text-gray-900 uppercase dark:text-white relative inline-block">
              Redes Sociais
              <span class="absolute bottom-0 left-0 w-full h-0.5 bg-gradient-to-r from-green-400 to-blue-500 transform scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></span>
            </h2>
            <ul class="text-gray-600 dark:text-gray-400 font-medium space-y-4">
              <li>
                <a href="https://www.facebook.com/eeparacati" class="hover:text-blue-500 dark:hover:text-blue-400 transition-colors duration-300 flex items-center gap-2">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                  Facebook
                </a>
              </li>
              <li>
                <a href="https://www.instagram.com/eparacati/" class="hover:text-pink-500 dark:hover:text-pink-400 transition-colors duration-300 flex items-center gap-2">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                  Instagram
                </a>
              </li>
            </ul>
          </div>
        </div>
        <hr class="my-8 border-gray-200/50 dark:border-gray-700/50" />
        <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">E.E.E.P Professora Elsa Maria Porto Costa Lima</span>
          <div class="flex mt-4 sm:justify-center sm:mt-0 space-x-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">© 2024 EP Aracati. Todos os direitos reservados.</p>
          </div>
        </div>
      </div>
    </footer>
  <?php
  }

  public static function renderApps($userRole)
  {
    $apps = self::getApps();

    $accessibleApps = array_filter($apps, function ($app) use ($userRole) {
      return in_array($userRole, $app["roles"]);
    });

    if (empty($accessibleApps)) {
      return;
    }
  ?>
    <section class="bg-gray-100 dark:bg-gray-900 py-8">
      <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-xl font-bold text-center mb-6 text-gray-800 dark:text-gray-200">APPS</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
          <?php foreach ($accessibleApps as $app): ?>
            <a href="<?= htmlspecialchars($app["path"]) ?>" class="block">
              <div
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center p-6 rounded-lg shadow hover:shadow-lg animate-fade-in-down hover:scale-105 transition-transform duration-300 ease-in-out">
                <i class="<?= $app["icon"] ?> text-4xl mb-4 text-gray-700 dark:text-gray-300"></i>
                <p class="text-gray-800 dark:text-gray-200 font-bold text-lg"><?= htmlspecialchars(
                                                                                $app["name"]
                                                                              ) ?></p>
                <div class="h-[4px] bg-green-600 mt-4"></div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php
  }

  public static function renderUserEditionPanel($user, $isAdmin = false)
  {
  ?>
    <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 transition-all duration-300 hover:shadow-xl">
      <form action="src/handlers/user/edit.php<?php echo $isAdmin ? '' : '?self'; ?>" method="POST"
        enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="space-y-4">
            <label for="profile_photo" class="block text-lg font-medium text-gray-900 dark:text-gray-100">Foto de Perfil</label>
            <div class="relative group mx-auto w-fit">
              <div class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-blue-500 rounded-full opacity-50 group-hover:opacity-70 blur transition duration-300"></div>
              <img id="output" src="<?php echo htmlspecialchars($user["profile_photo"]); ?>" alt="Foto de Perfil"
                class="relative w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-xl transform transition duration-300 group-hover:scale-105">
            </div>
            <div class="flex items-center gap-4">
              <div class="relative flex-1">
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                  onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                  class="block w-full text-sm text-gray-500 file:mr-3 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-green-500 file:to-blue-500 file:text-white hover:file:opacity-90 dark:text-gray-400 file:cursor-pointer transition-all duration-300">
              </div>
              <button type="button"
                onclick="if(confirm('Tem certeza que deseja deletar a foto de perfil?')) { window.location.href='src/handlers/user/deletePFP.php?id=<?php echo Security::hide($user['id']); ?>'; }"
                class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full p-2 hover:opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <i class="fas fa-times text-white"></i>
              </button>
            </div>
          </div>
          <div class="space-y-4">
            <label for="bio" class="block text-lg font-medium text-gray-900 dark:text-gray-100">Bio</label>
            <div class="relative">
              <div class="absolute inset-0 bg-gradient-to-r from-green-500/10 to-blue-500/10 dark:from-green-500/5 dark:to-blue-500/5 rounded-xl pointer-events-none"></div>
              <textarea id="bio" name="bio" maxlength="200" placeholder="Escreva algo sobre você..."
                class="relative w-full px-4 py-3 rounded-xl border-0 bg-white dark:bg-gray-700 shadow-lg focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 resize-none transition-all duration-300 dark:text-gray-100"
                style="height: 180px;"><?php echo htmlspecialchars($user["bio"]); ?></textarea>
            </div>
          </div>
          <?php if ($isAdmin): ?>
            <div>
              <label for="name" class="block text-gray-700 dark:text-gray-300">Nome</label>
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>
            <div>
              <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>
            <div>
              <label for="password" class="block text-gray-700 dark:text-gray-300">Senha</label>
              <input type="password" id="password" name="password" value=""
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>
            <div>
              <label for="role" class="block text-gray-700 dark:text-gray-300">Cargo</label>
              <select id="role" name="role"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <?php
                global $utils;
                $roles = ["aluno", "professor", "funcionario", "gestao"];
                ?>
                <?php if (!in_array($user["role"], $roles)): ?>
                  <option value="<?php echo $user["role"]; ?>" selected>
                    <?php echo Format::roleName($user['role'], true) ?>
                  </option>
                <?php endif; ?>
                <?php foreach ($roles as $role): ?>
                  <option value="<?php echo $role; ?>" <?php echo $user["role"] === $role ? "selected" : ""; ?>>
                    <?php echo Format::roleName($role, true); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div id="class-container" style="display: <?php echo $user["role"] === "aluno" ? "block" : "none"; ?>;">
              <label for="class" class="block text-gray-700 dark:text-gray-300">Turma</label>
              <select id="class" name="class"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <?php
                global $classController;
                $classes = $classController->get();
                ?>
                <option value="" <?php echo empty($user["class_id"]) ? "selected" : ""; ?>>Selecionar</option>
                <?php foreach ($classes as $class): ?>
                  <option value="<?php echo $class['id']; ?>"
                    <?php echo $user["class_id"] === $class['id'] ? "selected" : ""; ?>>
                    <?php echo $class['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          <?php endif; ?>
        </div>
        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
          Salvar Alterações
        </button>
        <?php if ($isAdmin): ?>
          <button type="button"
            onclick="if(confirm('Tem certeza que deseja deletar este usuário?')) { window.location.href='src/handlers/user/delete.php?id=<?php echo $user['id']; ?>'; }"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
            Deletar usuário
          </button>
        <?php endif; ?>
      </form>
    </div>
    <?php if ($isAdmin): ?>
      <script>
        document.getElementById('role').addEventListener('change', function() {
          var classContainer = document.getElementById('class-container');
          var classSelect = document.getElementById('class');
          if (this.value === 'aluno' || '') {
            classContainer.style.display = 'block';
          } else {
            classContainer.style.display = 'none';
            classSelect.selectedIndex = 0;
          }
        });
      </script>
    <?php endif; ?>
    <?php
  }



  // Funções de Renderização dinâmicas
  public function renderEquipments($type = null)
  {
    $equipmentController = $this->getEquipmentController();

    $statuses = ['disponivel', 'agendado', 'indisponivel'];
    $hasEquipments = false;

    foreach ($statuses as $status) {
      $filters = ['status' => $status];
      if ($type) {
        $filters['type'] = $type;
      }

      $equipments = $equipmentController->get([], $filters);

      if (!empty($equipments)) {
        $hasEquipments = true;
        foreach ($equipments as $row) {
          $statusInfo = [
            'disponivel' => ['color' => 'green', 'text' => 'Disponível'],
            'agendado' => ['color' => 'yellow', 'text' => 'Agendado'],
            'indisponivel' => ['color' => 'red', 'text' => 'Indisponível']
          ][$row['status']];
    ?>
          <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-1">
            <div class="relative overflow-hidden aspect-w-16 aspect-h-9">
              <img
                src="<?php echo !empty($row['image']) ? $row['image'] : 'https://placehold.co/900x600.png?text=' . Format::typeName($row['type']) . '&font=poppings'; ?>"
                alt="Imagem de <?php echo htmlspecialchars($row['name']); ?>"
                class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300">
              <div class="absolute top-3 right-3">
                <div class="flex items-center space-x-2 bg-white dark:bg-gray-800 rounded-full px-3 py-1 shadow-md">
                  <div class="w-2 h-2 rounded-full bg-<?php echo $statusInfo['color']; ?>-500 animate-pulse"></div>
                  <span class="text-xs font-medium text-<?php echo $statusInfo['color']; ?>-600 dark:text-<?php echo $statusInfo['color']; ?>-400">
                    <?php echo $statusInfo['text']; ?>
                  </span>
                </div>
              </div>
            </div>
            <div class="p-5">
              <div class="flex items-start justify-between mb-3">
                <div>
                  <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1 line-clamp-1">
                    <?php echo htmlspecialchars($row['name']) ?>
                  </h2>
                  <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    <?php echo Format::typeName($row['type']); ?>
                  </p>
                </div>
              </div>
              <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4">
                <?php echo htmlspecialchars($row['description']); ?>
              </p>
              <div class="flex justify-end">
                <a href="equipamentos.php?id=<?php echo Security::hide($row['id']); ?>"
                  class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                  <i class="fas fa-edit mr-2"></i>
                  Editar
                </a>
              </div>
            </div>
          </div>
      <?php
        }
      }
    }

    if (!$hasEquipments) { ?>
      <p class="text-center text-gray-500 dark:text-gray-400 flex justify-center">Nenhum equipamento
        <?php echo $type ? 'do tipo ' . Format::typeName($type) : ''; ?> encontrado.</p>
    <?php }
  }

  public function formatLogChangesToHtml($logData)
  {
    if (!isset($logData['message'])) {
      return "Erro: Dados de log inválidos ou incompletos.";
    }

    $message = $logData['message'];
    $changesText = "";

    if (strpos($message, "Mudanças: \n") !== false) {
      $changesText = explode("Mudanças: \n", $message)[1];
    } else {
      return "";
    }

    $fieldPattern = '/^(.+?):\s+(.+?)\s+>\s+/m';
    preg_match_all($fieldPattern, $changesText, $matches, PREG_OFFSET_CAPTURE);

    $htmlOutput = "";
    $totalMatches = count($matches[0]);

    for ($i = 0; $i < $totalMatches; $i++) {
      $fieldMatch = $matches[0][$i];
      $fieldName = trim($matches[1][$i][0]);
      $startPos = $fieldMatch[1];

      $endPos = ($i < $totalMatches - 1) ? $matches[0][$i + 1][1] : strlen($changesText);

      $fieldContent = substr($changesText, $startPos, $endPos - $startPos);

      if (preg_match('/^(.+?):\s+(.+?)\s+>\s+(.+)/s', $fieldContent, $valueMatches)) {
        $oldValue = trim($valueMatches[2]);
        $newValue = trim($valueMatches[3]);

        $formattedOldValue = $oldValue;
        $formattedNewValue = $newValue;

        if (strcasecmp($fieldName, "Status") === 0) {
          $formattedOldValue = Format::statusName($oldValue);
          $formattedNewValue = Format::statusName($newValue);
        } else if (strcasecmp($fieldName, "Cargo") === 0) {
          $formattedOldValue = Format::roleName($oldValue);
          $formattedNewValue = Format::roleName($newValue);
        } else if (strcasecmp($fieldName, "Tipo") === 0) {
          $formattedOldValue = Format::typeName($oldValue);
          $formattedNewValue = Format::typeName($newValue);
        }

        if (strcasecmp($fieldName, "Descrição") === 0 || strcasecmp($fieldName, "Biografia") === 0) {
          $formattedOldValue = nl2br(htmlspecialchars($formattedOldValue));
          $formattedNewValue = nl2br(htmlspecialchars($formattedNewValue));
        } else {
          $formattedOldValue = htmlspecialchars($formattedOldValue);
          $formattedNewValue = htmlspecialchars($formattedNewValue);
        }

        $htmlOutput .= '
  <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md mb-4">
      <div class="flex justify-between items-center mb-2">
          <span class="font-medium text-gray-700 dark:text-gray-300">' . htmlspecialchars($fieldName) . '</span>
          <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 text-xs rounded-full">Alterado</span>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded border border-red-100 dark:border-red-900">
              <span class="block text-xs text-red-500 dark:text-red-400 mb-1">Antes</span>
              <span class="text-gray-800 dark:text-gray-200">' . $formattedOldValue . '</span>
          </div>
          <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded border border-green-100 dark:border-green-900">
              <span class="block text-xs text-green-500 dark:text-green-400 mb-1">Depois</span>
              <span class="text-gray-800 dark:text-gray-200">' . $formattedNewValue . '</span>
          </div>
      </div>
  </div>';
      }
    }

    return $htmlOutput;
  }

  public function renderLogDetail($logData)
  {
    if (!isset($logData['action']) || !isset($logData['id'])) {
      return "Erro: Dados de log inválidos ou incompletos.";
    }

    $headerHtml = $this->getActionHeader($logData);

    $detailsHtml = "";

    return $headerHtml . $detailsHtml;
  }

  public function renderEquipmentsAgendae($type = null, $viewType = 'list', $time = null, $page = 1, $itemsPerPage = 9)
  {
    if ($time === null) {
      $currentHour = date('H:i');
      $timeSlots = ScheduleController::getTimeSlots();
      foreach ($timeSlots as $slot) {
        if ($currentHour >= $slot['start'] && $currentHour < $slot['end']) {
          $time = $slot['id'];
          break;
        }
      }
      $time = $time ?? 1;
    }

    if (isset($_GET['page'])) {
      $page = (int)$_GET['page'];
      if ($page < 1) $page = 1;
    }

    $offset = ($page - 1) * $itemsPerPage;

    $countSql = "SELECT COUNT(*) as total FROM equipments e";
    if (!empty($type)) {
      $countSql .= " WHERE e.type = :type";
    }

    $countStmt = $this->conn->prepare($countSql);
    if (!empty($type)) {
      $countStmt->bindValue(':type', $type);
    }

    $countStmt->execute();
    $totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalCount / $itemsPerPage);

    $sql = "SELECT e.*, b.id as booking_id, b.schedule, b.note, u.name as user_name 
              FROM equipments e 
              LEFT JOIN bookings b ON e.id = b.equipment_id AND b.schedule = :time
              LEFT JOIN users u ON b.user_id = u.id";

    if (!empty($type)) {
      $sql .= " WHERE e.type = :type";
    }

    $sql .= " ORDER BY e.name ASC LIMIT :limit OFFSET :offset";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':time', $time, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    if (!empty($type)) {
      $stmt->bindValue(':type', $type);
    }

    $stmt->execute();
    $equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $containerClass = $viewType === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4';
    echo "<div class=\"{$containerClass}\">";

    $renderMethod = $viewType === 'list' ? 'viewListEquipments' : 'viewGridEquipments';
    foreach ($equipments as $equipment) {
      $this->{$renderMethod}($equipment, $time);
    }

    echo '</div>';

    if ($totalPages > 1) {
      $this->setupPagination($page, $totalPages, $type, $time);
    }
  }

  public function renderBookings($basePath, $userId = null, $newBookingPanel = false)
  {

    $scheduleController = $this->getScheduleController();
    $userController = $this->getUserController();

    if ($newBookingPanel) {
      echo <<<HTML
      <div class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all h-auto">
        <a href="agendar.php" class="flex flex-col items-center justify-center h-full p-5 text-center">
          <div class="w-16 h-16 rounded-full bg-gradient-to-r from-green-500/10 to-blue-500/10 border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center mb-4 animate-fade-in-down hover:scale-105 transition-transform duration-300 ease-in-out">
            <i class="fas fa-plus text-2xl text-gray-600 dark:text-gray-400"></i>
          </div>
          <h3 class="font-medium mb-2 text-green-600 dark:text-green-400">Agendar</h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">Clique para fazer um novo agendamento</p>
        </a>
      </div>
    HTML;
    }

    $filters = [];
    if ($userId !== null) {
      $filters['user_id'] = $userId;
    }
    $bookings = $scheduleController->get($filters);
    $timeSlots = array_column($scheduleController->getTimeSlots(), null, 'id');

    if (empty($bookings)) {
      echo '<div class="col-span-full text-center py-8">
                  <div class="text-gray-500 dark:text-gray-400">
                    <p class="text-xl">Nenhum agendamento encontrado.</p>
                  </div>
                </div>';
      return;
    }

    foreach ($bookings as $booking) {
      $equipment = $booking['equipment_info'];
      $class = $booking['class_info'];

      $typeColors = self::getTypeColors();

      $typeClass = $typeColors[$equipment['type']] ?? 'bg-gray-600';
      $typeName = Format::typeName($equipment['type']);

      $imageSrc = $equipment['image'] ?: 'https://placehold.co/900x600.png?text=' . $typeName . '&font=poppings';

      $description = strlen($equipment['description']) > 100 ? substr(htmlspecialchars($equipment['description']), 0, 60) . '...' : htmlspecialchars($equipment['description']);

      $formattedDate = date('d/m/Y', strtotime($booking['date']));
      $formattedTime = $timeSlots[$booking['schedule']]['start'] . ' - ' . $timeSlots[$booking['schedule']]['end'] ?? 'Horário não definido';

      $userInfoHtml = '';
      if (empty($userId)) {
        $userInfo = $userController->getInfo($booking['user_id']);
        $userInfoHtml = '<div class="flex items-center font-bold text-xs text-purple-600 dark:text-purple-400 mb-1">
                                   <a href="' . $basePath . 'app/perfil.php?id=' . Security::hide($userInfo['id']) . '"><i class="fas fa-user mr-1"></i>' . htmlspecialchars($userInfo['name']) . '
                                   </a>
                                 </div>';
      }

      $classInfoHtml = '';
      if (!empty($booking['class_id']) && !empty($class)) {
        $classInfoHtml = '<div class="flex items-center text-xs text-green-600 dark:text-green-400 mb-1">
                                 <i class="fas fa-graduation-cap mr-1"></i> ' . htmlspecialchars($class['name']) . '
                               </div>';
      }

      $noteHtml = '';
      if (!empty($booking['note'])) {
        $shortNote = strlen($booking['note']) > 40 ? substr($booking['note'], 0, 40) . '...' : $booking['note'];
        $noteHtml = '<div class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                          <i class="fas fa-comment-alt mr-1"></i> ' . htmlspecialchars($shortNote) . '
                        </div>';
      }

    ?>
      <div class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all h-auto">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent"></div>
        <div class="relative">
          <div class="w-full h-52 flex items-center justify-center overflow-hidden bg-gray-100 dark:bg-gray-700">
            <img src="<?= $imageSrc ?>" class="" alt="<?= $equipment['name'] ?>">
          </div>

          <div class="absolute top-2 right-2">
            <span class="bg-yellow-500 text-xs px-2 py-0.5 rounded-full text-white shadow-sm">Agendado</span>
          </div>

          <div class="absolute top-2 left-2 animate-fade-in-down hover:scale-110 transition-transform duration-300 ease-in-out">
            <a href="<?php echo $basePath; ?>app/src/handlers/schedule/cancel.php?id=<?= $booking['id'] ?>"
              onclick="return confirm('Tem certeza que deseja cancelar este agendamento?');"
              class="bg-red-500 hover:bg-red-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center shadow-sm hover:shadow-md transition-all">
              <i class="fas fa-trash"></i>
            </a>
          </div>
        </div>
        <div class="relative p-3">
          <div class="flex justify-between mb-1">
            <span class="<?= $typeClass ?> text-xs px-2 py-0.5 rounded-full text-white shadow-sm"><?= $typeName ?></span>
            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
              <i class="far fa-calendar mr-1"></i> <?= $formattedDate ?>
            </span>
          </div>
          <h3 class="font-medium text-sm mb-1 truncate"><?= $equipment['name'] ?></h3>
          <p class="text-xs text-gray-600 dark:text-gray-400 mb-1 line-clamp-1"><?= $description ?></p>
          <div class="flex items-center text-xs text-gray-600 dark:text-gray-400 mb-1">
            <i class="far fa-clock mr-1"></i> <?= $formattedTime ?>
          </div>
          <?php if ($userInfoHtml) {
            echo $userInfoHtml;
          } ?>
          <?= $classInfoHtml ?>
          <?= $noteHtml ?>
        </div>
      </div>
<?php
    }
  }



  // Funções auxiliares
  private function getUserController()
  {
    return new UserController($this->conn);
  }

  private function getEquipmentController()
  {
    return new EquipmentController($this->conn);
  }

  private function getScheduleController()
  {
    return new ScheduleController($this->conn);
  }

  private static function getApps()
  {
    return [
      [
        "name" => "EPresence",
        "icon" => "fas fa-user-check",
        "roles" => ["lider", "professor", "gestao"],
        "path" => $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . "/eparacati/app/epresence/",
      ],
      [
        "name" => "Agendaê",
        "icon" => "fas fa-laptop",
        "roles" => ["professor", "gestao"],
        "path" => $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . "/eparacati/app/agendae/",
      ],
    ];
  }

  private function getActionHeader($logData)
  {
    $action = strtolower($logData['action']);
    $logId = htmlspecialchars($logData['id']);
    $timestamp = Format::date(htmlspecialchars($logData['timestamp']));
    $userName = isset($logData['user_name']) ? htmlspecialchars($logData['user_name']) : 'Sistema';
    $title = $this->getActionTitle($logData);

    $actionConfig = [
      'add'    => ['color' => 'green', 'icon' => 'fa-solid fa-plus', 'label' => 'CREATE'],
      'book'   => ['color' => 'emerald', 'icon' => 'fa-solid fa-book', 'label' => 'BOOK'],
      'update' => ['color' => 'blue', 'icon' => 'fa-solid fa-pen-to-square', 'label' => 'UPDATE'],
      'delete' => ['color' => 'red', 'icon' => 'fa-solid fa-trash', 'label' => 'DELETE'],
      'view'   => ['color' => 'amber', 'icon' => 'fa-solid fa-eye', 'label' => 'VIEW'],
      'login'  => ['color' => 'purple', 'icon' => 'fa-solid fa-right-to-bracket', 'label' => 'LOGIN'],
      'logout' => ['color' => 'indigo', 'icon' => 'fa-solid fa-right-from-bracket', 'label' => 'LOGOUT'],
      'default' => ['color' => 'gray', 'icon' => 'fa-solid fa-circle-info', 'label' => 'ACTION']
    ];

    $config = $actionConfig[$action] ?? $actionConfig['default'];
    $color = $config['color'];
    $icon = $config['icon'];
    $label = $config['label'];

    return $this->renderHeaderTemplate($logId, $timestamp, $userName, $title, $color, $icon, $label);
  }

  private function getActionTitle($logData)
  {
    $action = strtolower($logData['action']);
    $target = '';

    if (isset($logData['target_table'])) {
      $target = ucfirst(rtrim(Format::tableName($logData['target_table']), 's'));
    }

    $targetName = '';
    if (isset($logData['message']) && preg_match("/'([^']+)'/", $logData['message'], $matches)) {
      $targetName = $matches[1];
    }

    $titleMap = [
      'add'    => "Novo(a) {$target} '{$targetName}' criado(a)",
      'book'   => "Equipamento '{$targetName}' reservado",
      'update' => "{$target} '{$targetName}' atualizado(a)",
      'delete' => "{$target} '{$targetName}' deletado(a)",
      'view'   => "{$target} visualizado",
      'login'  => "Usuário logado no sistema",
      'logout' => "Usuário encerrou sessão no sistema",
    ];

    return $titleMap[$action] ?? "Ação performada: " . ucfirst($action);
  }

  private static function getTypeColors()
  {
    return [
      'notebook' => 'bg-purple-600',
      'espaco' => 'bg-indigo-600',
      'projetor' => 'bg-blue-600',
      'extensao' => 'bg-green-600',
      'microfone' => 'bg-orange-600',
      'caixadesom' => 'bg-yellow-600',
      'cabo' => 'bg-teal-600',
      'outro' => 'bg-gray-600',
    ];
  }

  private function setupPagination($currentPage, $totalPages, $type, $time)
  {
    $typeParam = !empty($type) ? '&type=' . $type : '';
    $timeParam = $time ? "&time={$time}" : "";

    $prevPage = max(1, $currentPage - 1);
    $nextPage = min($totalPages, $currentPage + 1);

    $prevUrl = "?page={$prevPage}{$typeParam}{$timeParam}";
    $nextUrl = "?page={$nextPage}{$typeParam}{$timeParam}";

    $pagesToShow = [];
    $pagesToShow[] = 1;

    $startRange = max(2, $currentPage - 1);
    $endRange = min($totalPages - 1, $currentPage + 1);

    if ($startRange > 2) {
      $pagesToShow[] = 'ellipsis1';
    }

    for ($i = $startRange; $i <= $endRange; $i++) {
      $pagesToShow[] = $i;
    }

    if ($endRange < $totalPages - 1) {
      $pagesToShow[] = 'ellipsis2';
    }

    if ($totalPages > 1) {
      $pagesToShow[] = $totalPages;
    }

    echo <<<HTML
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paginationNav = document.querySelector('nav[aria-label="Pagination"]');
        if (paginationNav) {
            const prevLink = paginationNav.querySelector('a:first-child');
            prevLink.href = "{$prevUrl}";
            prevLink.classList.toggle('cursor-not-allowed', {$currentPage} <= 1);
            
            const nextLink = paginationNav.querySelector('a:last-child');
            nextLink.href = "{$nextUrl}";
            nextLink.classList.toggle('cursor-not-allowed', {$currentPage} >= {$totalPages});
            
            const pageLinks = paginationNav.querySelectorAll('a:not(:first-child):not(:last-child), span');
            pageLinks.forEach(link => link.remove());
            
            const pageUrls = {
    HTML;
    foreach ($pagesToShow as $page) {
      if ($page === 'ellipsis1' || $page === 'ellipsis2') {
        continue;
      }
      $url = "?page={$page}{$typeParam}{$timeParam}";
      echo "                {$page}: \"{$url}\",\n";
    }

    echo <<<HTML
            };
            const nextLinkElement = nextLink.parentNode;
    HTML;

    foreach ($pagesToShow as $page) {
      if ($page === 'ellipsis1' || $page === 'ellipsis2') {
        echo <<<HTML
            nextLinkElement.insertBefore(
                createElement('span', {
                    class: 'relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300',
                    textContent: '...'
                }),
                nextLink
            );
    HTML;
      } else {
        $isActive = $page == $currentPage;
        $pageClass = $isActive
          ? 'relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-green-500 text-sm font-medium text-white'
          : 'relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700';

        echo <<<HTML
            nextLinkElement.insertBefore(
                createElement('a', {
                    href: pageUrls[{$page}],
                    class: '{$pageClass}',
                    textContent: '{$page}'
                }),
                nextLink
            );
    HTML;
      }
    }

    echo <<<HTML
            function createElement(tag, attributes) {
                const element = document.createElement(tag);
                for (const key in attributes) {
                    if (key === 'textContent') {
                        element.textContent = attributes[key];
                    } else {
                        element.setAttribute(key, attributes[key]);
                    }
                }
                return element;
            }
        }
    });
    </script>
HTML;
  }



  // Funções estruturais
  private function renderHeaderTemplate($logId, $timestamp, $userName, $title, $color, $icon, $label)
  {
    return <<<HTML
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
      <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-start">
          <div class="flex-shrink-0 mr-4">
            <div class="h-12 w-12 rounded-full bg-{$color}-100 dark:bg-{$color}-900 flex items-center justify-center">
              <i class="{$icon} text-{$color}-600 dark:text-{$color}-400 text-xl"></i>
            </div>
          </div>
          <div class="flex-1">
            <div class="flex items-center mb-2">
              <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{$color}-100 text-{$color}-800 dark:bg-{$color}-900 dark:text-{$color}-300">{$label}</span>
              <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{$title}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
              <div>
                <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
                <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{$logId}</p>
              </div>
              <div>
                <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
                <p class="font-medium text-gray-800 dark:text-gray-200">{$timestamp}</p>
              </div>
              <div>
                <p class="text-gray-500 dark:text-gray-400">Responsável</p>
                <p class="font-medium text-gray-800 dark:text-gray-200">{$userName}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    HTML;
  }

  private function viewGridEquipments($equipment, $time)
  {
    $status = $equipment['status'];
    $statusClass = 'bg-green-500';
    $statusText = 'Disponível';
    $gradientClass = 'from-blue-500/5';
    $animation = 'animate-fade-in-down hover:scale-105 transition-transform duration-300 ease-in-out';
    $typeClass = 'bg-blue-600';
    $link = 'equipamento.php?id=' . Security::hide($equipment['id']);
    $onClick = 'agendar.php?id=' . Security::hide($equipment['id']);
    $buttonClass = 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700';
    $buttonText = '<i class="fas fa-calendar-plus mr-2"></i> Agendar';
    $buttonDisabled = '';

    if ($equipment['booking_id']) {
      $status = 'agendado';
      $statusClass = 'bg-yellow-500';
      $statusText = 'Agendado';
      $gradientClass = 'from-red-500/5';
      $animation = '';
      $onClick = '';
      $buttonClass = 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed';
      $buttonText = '<i class="fas fa-ban mr-2"></i> Indisponível';
      $buttonDisabled = 'disabled';
    } elseif ($status == 'indisponivel') {
      $statusClass = 'bg-red-500';
      $statusText = 'Indisponível';
      $gradientClass = 'from-red-500/5';
      $animation = '';
      $onClick = '';
      $buttonClass = 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed';
      $buttonText = '<i class="fas fa-ban mr-2"></i> Indisponível';
      $buttonDisabled = 'disabled';
    }

    $typeColors = self::getTypeColors();
    $typeClass = $typeColors[$equipment['type']] ?? 'bg-gray-600';
    $imageSrc = $equipment['image'] ?: 'https://placehold.co/900x600.png?text=' . Format::typeName($equipment['type']) . '&font=poppings';
    $typeName = Format::typeName($equipment['type']);
    $description = strlen($equipment['description']) > 300 ? substr(htmlspecialchars($equipment['description']), 0, 100) . '...' : htmlspecialchars($equipment['description']);

    echo <<<HTML
    
          <div class="relative bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg {$animation}">
              <div class="absolute inset-0 bg-gradient-to-br {$gradientClass} to-transparent"></div>
              <div class="relative">
                  <img src="{$imageSrc}" class="w-full h-48 object-cover" alt="{$equipment['name']}">
                  <div class="absolute top-3 right-3">
                      <span class="{$statusClass} text-xs px-2 py-1 rounded-full text-white shadow-sm">{$statusText}</span>
                  </div>
              </div>
              <div class="relative p-5">
                  <div class="flex justify-between mb-2">
                      <span class="{$typeClass} text-xs px-2 py-1 rounded-full text-white shadow-sm">{$typeName}</span>
                  </div>
                  <a href="{$link}"><h3 class="font-medium mb-1">{$equipment['name']}</h3></a>
                  <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{$description}</p>
                  <button {$buttonDisabled} onclick="window.location.href='{$onClick}'" class="w-full {$buttonClass} text-white font-medium py-2 rounded-lg shadow-sm hover:shadow-md" data-equipment-id="{$equipment['id']}">
                      {$buttonText}
                  </button>
              </div>
          </div>
  HTML;
  }

  private function viewListEquipments($equipment, $time)
  {
    $status = $equipment['status'];
    $statusClass = 'bg-green-500';
    $statusIcon = 'fas fa-check';
    $typeClass = 'bg-blue-600';
    $animation = 'animate-fade-in-down hover:scale-105 transition-transform duration-300 ease-in-out';
    $link = 'equipamento.php?id=' . Security::hide($equipment['id']);
    $onClick = 'agendar.php?id=' . Security::hide($equipment['id']);
    $buttonClass = 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700';
    $buttonText = '<i class="fas fa-calendar-plus mr-2"></i> Agendar';
    $buttonDisabled = '';

    if ($equipment['booking_id']) {
      $status = 'agendado';
      $statusClass = 'bg-yellow-500';
      $statusIcon = 'fas fa-calendar-alt';
      $animation = '';
      $onClick = '';
      $buttonClass = 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed';
      $buttonText = '<i class="fas fa-ban mr-2"></i> Indisponível';
      $buttonDisabled = 'disabled';
    } elseif ($status == 'indisponivel') {
      $statusClass = 'bg-red-500';
      $statusIcon = 'fas fa-times';
      $animation = '';
      $onClick = '';
      $buttonClass = 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed';
      $buttonText = '<i class="fas fa-ban mr-2"></i> Indisponível';
      $buttonDisabled = 'disabled';
    }

    $typeColors = self::getTypeColors();
    $typeClass = $typeColors[$equipment['type']] ?? 'bg-gray-600';
    $typeName = Format::typeName($equipment['type']);
    $description = htmlspecialchars($equipment['description']);
    $fullDescription = htmlspecialchars($equipment['description']);

    echo <<<HTML
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg {$animation} mb-4">
              <div class="flex items-center w-full sm:w-auto">
                  <div class="mr-4">
                      <div class="{$statusClass} w-10 h-10 rounded-full flex items-center justify-center">
                          <i class="{$statusIcon} text-white text-xl"></i>
                      </div>
                  </div>
                  <div class="flex-1 min-w-0">
                  <a href="{$link}"><h3 class="font-medium text-lg sm:text-base truncate" title="{$equipment['name']}">{$equipment['name']}</h3></a>
                      <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" title="{$fullDescription}">{$description}</p>
                      <span class="{$typeClass} text-xs px-2 py-1 rounded-full text-white shadow-sm mt-2 inline-block">{$typeName}</span>
                  </div>
              </div>
              <button {$buttonDisabled} onclick="window.location.href='{$onClick}'" class="mt-4 sm:mt-0 w-full sm:w-auto {$buttonClass} text-white font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300" data-equipment-id="{$equipment['id']}">
                  {$buttonText}
              </button>
          </div>
  HTML;
  }
}
