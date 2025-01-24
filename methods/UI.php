<?php
require_once 'bootstrap.php';

class UI
{
  public static function renderNavbar($currentUser, $basePath, $activePage = "Home", $color = "green", $logo = "logo.svg")
  {
    $links = [
      "Home" => "{$basePath}index.php",
      "Conexão Acadêmica" => "{$basePath}#",
      "Dashboard" => "{$basePath}dashboard/",
    ];

    $methodsPath = "{$basePath}methods";
    $assetsPath = "{$basePath}assets";
    $profilePath = "{$basePath}perfil.php";
?>
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?php echo $basePath; ?>index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="<?php echo $assetsPath; ?>/images/<?php echo $logo; ?>" class="h-8" alt="EP Aracati Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">EP Aracati</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse relative inline-block">
          <button type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button" aria-expanded="false">
            <span class="sr-only">Menu do usuário</span>
            <img class="w-8 h-8 rounded-full" src="<?php echo $currentUser["profile_photo"]; ?>" alt="Foto do usuário">
          </button>
          <div
            class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-600 absolute top-full right-0 mt-2"
            id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white"><?php echo $currentUser["name"]; ?></span>
              <span
                class="block text-sm text-<?php echo $color; ?>-600 truncate dark:text-<?php $color; ?>-400"><?php echo $currentUser["email"]; ?></span>
            </div>
            <ul class="py-2">
              <li>
                <a href="<?php echo $profilePath; ?>"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Meu
                  perfil</a>
              </li>
              <li>
                <form action="<?php echo $methodsPath; ?>/handlers/user/theme.php" method="POST">
                  <button type="submit"
                    class="block w-full px-4 py-2 text-sm text-gray-700 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Alternar tema
                  </button>
                </form>
              </li>
              <li>
                <a href="<?php echo $methodsPath; ?>/handlers/user/logout.php"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sair</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="w-full mt-4 md:mt-0 md:w-auto md:flex md:items-center md:order-1">
          <ul
            class="flex flex-wrap justify-center md:flex-nowrap font-medium p-4 md:p-0 border border-none rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-none">
            <?php foreach ($links as $name => $url): ?>
              <li>
                <a href="<?php echo $url; ?>" class="block py-2 px-3 <?php echo $name === $activePage
                                                                        ? "text-" .
                                                                        $color .
                                                                        "-600 bg-" .
                                                                        $color .
                                                                        "-700 rounded md:bg-transparent md:text-" .
                                                                        $color .
                                                                        "-700 md:dark:text-" .
                                                                        $color .
                                                                        "-500"
                                                                        : "text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-" .
                                                                        $color .
                                                                        "-700 dark:text-white md:dark:hover:text-" .
                                                                        $color .
                                                                        "-500 dark:hover:bg-gray-700 dark:hover:text-white"; ?>">
                  <?php echo $name; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
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
      <form action="methods/handlers/user/edit.php<?php echo $isAdmin ? '' : '?self'; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="profile_photo" class="block text-gray-700 dark:text-gray-300">Foto de Perfil</label>
            <div class="mt-2 mb-2 flex justify-center items-center space-x-2">
              <img id="output"
                src="<?php echo htmlspecialchars($user["profile_photo"]); ?>"
                alt="Foto de Perfil"
                class="w-32 h-32 rounded-full object-cover">
            </div>
            <div class="flex items-center gap-4">
              <div class="relative">
                <input type="file"
                  id="profile_photo"
                  name="profile_photo"
                  accept="image/*"
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
            <textarea id="bio" name="bio" maxlength="200" class="shadow-lg w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" style="height: 180px;"><?php echo $user["bio"]; ?></textarea>
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
                  <option value="<?php echo $role; ?>"
                    <?php echo $user["role"] === $role ? "selected" : ""; ?>>
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
                  <option value="<?php echo $class['id']; ?>" <?php echo $user["class_id"] === $class['id'] ? "selected" : ""; ?>>
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
          <button type="button" onclick="if(confirm('Tem certeza que deseja deletar este usuário?')) { window.location.href='methods/handlers/user/delete.php?id=<?php echo $user['id']; ?>'; }" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
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
