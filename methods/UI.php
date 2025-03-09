<?php
require_once 'bootstrap.php';

class UI
{
  public static function renderNavbar($currentUser, $basePath, $activePage = "Home", $color = "green", $logo = "logo.svg")
  {
    $links = [
      "Home" => "{$basePath}index.php",
      "Conexão Acadêmica" => "{$basePath}indev.php",
      "Dashboard" => "{$basePath}dashboard/",
    ];

    $methodsPath = "{$basePath}methods";
    $assetsPath = "{$basePath}assets";
    $profilePath = "{$basePath}perfil.php";
?>

    <nav class="bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex-shrink-0 flex items-center">
            <a href="#" class="flex items-center">
              <img src="<?php echo $assetsPath; ?>/images/<?php echo $logo; ?>" class="h-8" alt="EP Aracati Logo" />
              <span class="ml-2 text-xl font-bold text-gray-800 dark:text-white">EP Aracati</span>
            </a>
          </div>

          <div class="flex items-center sm:hidden">
            <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary">
              <span class="sr-only">Abrir menu</span>
              <svg id="menu-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg id="close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
              <button id="user-menu-button" type="button" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary dark:focus:ring-offset-gray-800" aria-expanded="false" aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                <img class="h-8 w-8 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm" src="<?php echo $currentUser["profile_photo"]; ?>" alt="Foto do usuário">
              </button>

              <div id="user-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700 focus:outline-none z-10">
                <div class="px-4 py-3">
                  <p class="text-sm font-medium text-gray-900 dark:text-white"><?= $currentUser["name"]; ?></p>
                  <p class="text-sm text-<?= $color ?>-600 dark:text-<?= $color ?>-400 truncate"><?= $currentUser["email"]; ?></p>
                </div>
                <div class="py-1">
                  <a href="<?php echo $profilePath; ?>" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-150">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Meu perfil
                  </a>
                  <form action="<?php echo $methodsPath; ?>/handlers/user/theme.php" method="POST">
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-150 text-left">
                      <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                      </svg>
                      Alternar tema
                    </button>
                  </form>
                  <a href="#" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-gray-100 dark:text-red-600 dark:hover:bg-gray-700 transition-colors duration-150">
                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
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
              <img class="h-10 w-10 rounded-full object-cover" src="<?php echo $currentUser["profile_photo"]; ?>" alt="Foto do usuário">
            </div>
            <div class="ml-3">
              <div class="text-base font-medium text-gray-800 dark:text-white"><?= $currentUser["name"]; ?></div>
              <div class="text-sm font-medium text-<?= $color ?>-600 dark:text-<?= $color ?>-400"><?= $currentUser["email"]; ?></div>
            </div>
          </div>
          <div class="mt-3 px-2 space-y-1">
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">Meu perfil</a>
            <form action="<?php echo $methodsPath; ?>/handlers/user/theme.php" method="POST"><button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-primary hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700">Alternar tema</button></form>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-red-700 hover:text-primary hover:bg-gray-50 dark:text-red-600 dark:hover:bg-gray-700">Sair</a>
          </div>
        </div>
      </div>
    </nav>
    <script src="<?php echo $assetsPath; ?>/js/navbar.js"></script>

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

  public static function renderEquipments($conn, $type = null)
  {
    $statuses = ['disponivel', 'agendado', 'indisponivel'];
    $hasEquipments = false;

    foreach ($statuses as $status) {
      $sql = 'SELECT * FROM equipments WHERE status = :status';
      if ($type) {
        $sql .= " AND type = :type";
      }
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':status', $status);
      if ($type) {
        $stmt->bindParam(':type', $type);
      }
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $hasEquipments = true;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $statusInfo = [
            'disponivel' => ['color' => 'green', 'text' => 'Disponível'],
            'agendado' => ['color' => 'yellow', 'text' => 'Agendado'],
            'indisponivel' => ['color' => 'red', 'text' => 'Indisponível']
          ][$row['status']];

          $typeInfo = [
            'notebook' => 'Notebook',
            'projetor' => 'Projetor',
            'extensao' => 'Extensão',
            'sala' => 'Sala',
            'outro' => 'Outro'
          ][$row['type']];
    ?>
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-colors duration-300">
            <img src="<?php echo !empty($row['image']) ? $row['image'] : 'https://placehold.co/900x600.png'; ?>"
              alt="Imagem de <?php echo htmlspecialchars($row['name']); ?>" class="w-full h-48 object-cover">
            <div class="p-4">
              <div class="flex items-center mb-2">
                <div class="w-3 h-3 rounded-full bg-<?php echo $statusInfo['color']; ?>-500 mr-2"></div>
                <span
                  class="text-sm font-semibold text-<?php echo $statusInfo['color']; ?>-600 dark:text-<?php echo $statusInfo['color']; ?>-400"><?php echo $statusInfo['text']; ?></span>
              </div>
              <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($row['name']) ?></h2>
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-3"><?php echo $typeInfo; ?></p>
              <p class="text-gray-600 dark:text-gray-300 mb-4">
                <?php echo strlen($row['description']) > 300 ? substr(htmlspecialchars($row['description']), 0, 300) . '...' : htmlspecialchars($row['description']); ?>
              </p>
              <a href="equipamentos.php?id=<?php echo Utils::hide($row['id']); ?>"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-edit"></i>
              </a>
            </div>
          </div>
      <?php
        }
      }
    }

    if (!$hasEquipments) { ?>
      <p class="text-center text-gray-500 dark:text-gray-400 flex justify-center">Nenhum equipamento
        <?php echo $type ? 'do tipo ' . $typeInfo : ''; ?> encontrado.</p>
    <?php }
  }
  private static function getApps()
  {
    return [
      [
        "name" => "EPresence",
        "icon" => "fas fa-user-check",
        "roles" => ["lider", "professor", "gestao"],
        "path" => "apps/epresence.php",
      ],
      [
        "name" => "Agendar Equipamentos",
        "icon" => "fas fa-laptop",
        "roles" => ["professor", "gestao"],
        "path" => "apps/agendar.php",
      ],
    ];
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
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center p-6 rounded-lg shadow hover:shadow-lg transition">
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
    <div class="md:col-span-3 p-4 rounded-lg bg-white dark:bg-gray-800">
      <form action="methods/handlers/user/edit.php<?php echo $isAdmin ? '' : '?self'; ?>" method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="profile_photo" class="block text-gray-700 dark:text-gray-300">Foto de Perfil</label>
            <div class="mt-2 mb-2 flex justify-center items-center space-x-2">
              <img id="output" src="<?php echo htmlspecialchars($user["profile_photo"]); ?>" alt="Foto de Perfil"
                class="w-32 h-32 rounded-full object-cover">
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                  onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                  class="block w-full text-sm text-gray-500 file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-green-700 hover:file:bg-gray-300 dark:file:bg-gray-700 dark:file:text-green-500 dark:hover:file:bg-gray-600 file:w-auto file:cursor-pointer">
              </div>
              <button type="button"
                onclick="if(confirm('Tem certeza que deseja deletar a foto de perfil?')) { window.location.href='methods/handlers/user/deletePFP.php?id=<?php echo Utils::hide($user['id']); ?>'; }"
                class="w-9 h-9 bg-red-600 text-white rounded-lg p-2 hover:bg-red-700 transition-all">
                <i class="fas fa-times text-white"></i>
              </button>
            </div>
          </div>
          <div>
            <label for="bio" class="block text-gray-700 dark:text-gray-300">Bio</label>
            <textarea id="bio" name="bio" maxlength="200"
              class="shadow-lg w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
              style="height: 180px;"><?php echo htmlspecialchars($user["bio"]); ?></textarea>
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
                    <?php echo Utils::formatRoleName($user['role'], true) ?>
                  </option>
                <?php endif; ?>
                <?php foreach ($roles as $role): ?>
                  <option value="<?php echo $role; ?>" <?php echo $user["role"] === $role ? "selected" : ""; ?>>
                    <?php echo Utils::formatRoleName($role, true); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div id="class-container" style="display: <?php echo $user["role"] === "aluno" ? "block" : "none"; ?>;">
              <label for="class" class="block text-gray-700 dark:text-gray-300">Turma</label>
              <select id="class" name="class"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <?php
                global $classManager;
                $classes = $classManager->getAllClasses();
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
            onclick="if(confirm('Tem certeza que deseja deletar este usuário?')) { window.location.href='methods/handlers/user/delete.php?id=<?php echo $user['id']; ?>'; }"
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
          $formattedOldValue = Utils::formatStatusName($oldValue);
          $formattedNewValue = Utils::formatStatusName($newValue);
        } else if (strcasecmp($fieldName, "Cargo") === 0) {
          $formattedOldValue = Utils::formatRoleName($oldValue);
          $formattedNewValue = Utils::formatRoleName($newValue);
        } else if (strcasecmp($fieldName, "Tipo") === 0) {
          $formattedOldValue = Utils::formatTypeName($oldValue);
          $formattedNewValue = Utils::formatTypeName($newValue);
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

  private function getActionHeader($logData)
  {
    $action = strtolower($logData['action']);

    $logId = htmlspecialchars($logData['id']);
    $timestamp = htmlspecialchars($logData['timestamp']);
    $userName = isset($logData['user_name']) ? htmlspecialchars($logData['user_name']) : 'Sistema';

    $title = $this->getActionTitle($logData);

    switch ($action) {
      case 'create':
        $template = $this->getCreateHeaderTemplate();
        break;
      case 'update':
        $template = $this->getUpdateHeaderTemplate();
        break;
      case 'delete':
        $template = $this->getDeleteHeaderTemplate();
        break;
      case 'view':
        $template = $this->getViewHeaderTemplate();
        break;
      case 'login':
        $template = $this->getLoginHeaderTemplate();
        break;
      case 'logout':
        $template = $this->getLogoutHeaderTemplate();
        break;
      default:
        $template = $this->getGenericHeaderTemplate();
        break;
    }

    $header = str_replace(
      ['{{LOG_ID}}', '{{TIMESTAMP}}', '{{USER_NAME}}', '{{TITLE}}'],
      [$logId, Utils::formatDate($timestamp), $userName, $title],
      $template
    );

    return $header;
  }

  private function getActionTitle($logData)
  {
    $action = strtolower($logData['action']);
    $target = '';

    function getSingularTarget($tableName)
    {
      $singular = rtrim($tableName, 's');
      return ucfirst($singular);
    }

    if (isset($logData['target_table'])) {
      $target = getSingularTarget(Utils::formatTableName($logData['target_table']));
    }

    $targetName = '';
    if (isset($logData['message']) && preg_match("/'([^']+)'/", $logData['message'], $matches)) {
      $targetName = $matches[1];
    }

    switch ($action) {
      case 'add':
        return "Novo(a) {$target} '{$targetName}' criado(a)";
      case 'update':
        return "{$target} '{$targetName}' atualizado(a)";
      case 'delete':
        return "{$target} '{$targetName}' deletado(a)";
      case 'view':
        return "{$target} visualizado";
      case 'login':
        return "Usuário logado no sistema";
      case 'logout':
        return "Usuário encerrou sessão no sistema";
      default:
        return "Ação performada: " . ucfirst($action);
    }
  }

  private function getCreateHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">CREATE</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getUpdateHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">UPDATE</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getDeleteHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">DELETE</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getViewHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300">VIEW</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getLoginHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">LOGIN</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getLogoutHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">LOGOUT</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  private function getGenericHeaderTemplate()
  {
    return '
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
  <div class="p-6 border-b border-gray-200 dark:border-gray-700">
    <div class="flex items-start">
      <div class="flex-shrink-0 mr-4">
        <div class="h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex items-center mb-2">
          <span class="px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">ACTION</span>
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{TITLE}}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">ID do registro</p>
            <p id="logId" class="font-medium text-gray-800 dark:text-gray-200">{{LOG_ID}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Data & Hora</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{TIMESTAMP}}</p>
          </div>
          <div>
            <p class="text-gray-500 dark:text-gray-400">Responsável</p>
            <p class="font-medium text-gray-800 dark:text-gray-200">{{USER_NAME}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
  }

  public static function renderFooter($basePath)
  {
  ?>
    <footer class="bg-white dark:bg-gray-900">
      <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
            <a href="<?php echo $basePath; ?>index.php" class="flex items-center">
              <img src="<?php echo $basePath; ?>assets/images/logo.svg" class="h-8 me-3" alt="EP Aracati Logo" />
              <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">EP Aracati</span>
            </a>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
              <ul class="text-gray-500 dark:text-gray-400 font-medium">
                <li class="mb-4">
                  <a href="https://www.instagram.com/eparacati/" class="hover:underline">Política de privacidade</a>
                </li>
                <li>
                  <a href="https://www.instagram.com/gremioadolfocaminha/" class="hover:underline">Termos e serviços</a>
                </li>
              </ul>
            </div>
            <div>
              <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Siga-nos</h2>
              <ul class="text-gray-500 dark:text-gray-400 font-medium">
                <li class="mb-4">
                  <a href="https://www.facebook.com/eeparacati" class="hover:underline ">Facebook</a>
                </li>
                <li>
                  <a href="https://www.instagram.com/eparacati/" class="hover:underline">Instagram</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">E.E.E.P Professora Elsa Maria Porto Costa
            Lima</span>
        </div>
      </div>
    </footer>
<?php
  }
}
