<?php

class UI
{
  public static function renderNavbar($basePath, $activePage = 'Home', $color = 'green', $logo = 'logo.svg')
  {
    // Links do menu
    $links = [
      'Home' => "{$basePath}index.php",
      'Conexão Acadêmica' =>  "{$basePath}#",
      'Dashboard' => "{$basePath}dashboard/",
    ];

    $methodsPath = "{$basePath}methods";
    $assetsPath = "{$basePath}assets";
    $profilePath = "{$basePath}perfil.php";

?>
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
      <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?php echo $basePath; ?>index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="<?php echo $assetsPath; ?>/images/<?php echo $logo ?>" class="h-8" alt="EP Aracati Logo" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">EP Aracati</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse relative inline-block">
          <button
            type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button"
            aria-expanded="false">
            <span class="sr-only">Menu do usuário</span>
            <img class="w-8 h-8 rounded-full" src="<?php echo $_SESSION['profile_photo']; ?>" alt="Foto do usuário">
          </button>
          <div
            class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 absolute top-full right-0 mt-2"
            id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white"><?php echo $_SESSION['name']; ?></span>
              <span class="block text-sm text-<?php echo $color ?>-600 truncate dark:text-<?php $color ?>-400"><?php echo $_SESSION['email']; ?></span>
            </div>
            <ul class="py-2">
              <li>
                <a href="<?php echo $profilePath; ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Meu perfil</a>
              </li>
              <li>
                <form action="<?php echo $methodsPath ?>/handlers/theme.php" method="POST">
                  <button type="submit" class="block w-full px-4 py-2 text-sm text-gray-700 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Alternar tema
                  </button>
                </form>
              </li>
              <li>
                <a href="<?php echo $methodsPath; ?>/handlers/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sair</a>
              </li>
            </ul>
          </div>
        </div>

        <div class="w-full mt-4 md:mt-0 md:w-auto md:flex md:items-center md:order-1">
          <ul class="flex flex-wrap justify-center md:flex-nowrap font-medium p-4 md:p-0 border border-none rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-none">
            <?php foreach ($links as $name => $url): ?>
              <li>
                <a href="<?php echo $url; ?>"
                  class="block py-2 px-3 <?php echo $name === $activePage ? 'text-' . $color . '-600 bg-' . $color . '-700 rounded md:bg-transparent md:text-' . $color . '-700 md:dark:text-' . $color . '-500' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-' . $color . '-700 dark:text-white md:dark:hover:text-' . $color . '-500 dark:hover:bg-gray-700 dark:hover:text-white'; ?>">
                  <?php echo $name; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </nav>
    <script src="<?php echo $assetsPath ?>/js/navbar.js"></script>

  <?php
  }

  public static function renderCarousel($basePath, $items)
  {
    $assetsPath = "{$basePath}assets";
  ?>
    <div class="relative w-full max-w-screen-lg mx-auto mt-4 overflow-hidden rounded-lg">
      <div id="carousel" class="flex transition-transform duration-700 ease-in-out w-full h-64 sm:h-80 lg:h-96">
        <?php foreach ($items as $item): ?>
          <div class="w-full flex-shrink-0 h-full">
            <img src="<?= $item['image'] ?>" alt="<?= $item['title'] ?>"
              class="w-full h-full object-contain bg-gray-100 dark:bg-gray-800">
          </div>
        <?php endforeach; ?>
      </div>

      <button id="prevBtn"
        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 dark:bg-gray-600 text-white dark:text-gray-200 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full hover:bg-gray-600 dark:hover:bg-gray-500 z-10">
        &lt;
      </button>

      <button id="nextBtn"
        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 dark:bg-gray-600 text-white dark:text-gray-200 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full hover:bg-gray-600 dark:hover:bg-gray-500 z-10">
        &gt;
      </button>
      <div id="indicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <?php foreach ($items as $index => $item): ?>
          <button
            class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-gray-400 dark:bg-gray-600"
            data-index="<?= $index ?>"></button>
        <?php endforeach; ?>
      </div>
    </div>
    <script src="<?php echo $assetsPath ?>/js/carousel.js"></script>
  <?php
  }

  private static function getApps()
  {
    return [
      ["name" => "EPresence", "icon" => "fas fa-user-check", "roles" => ["lider", "professor", "gestao"], "path" => "apps/epresence.php"],
      ["name" => "Agendar Equipamentos", "icon" => "fas fa-laptop", "roles" => ["professor", "gestao"], "path" => "apps/agendar.php"]
    ];
  }

  public static function renderApps($userRole)
  {
    $apps = self::getApps();

    $accessibleApps = array_filter($apps, function ($app) use ($userRole) {
      return in_array($userRole, $app['roles']);
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
            <a href="<?= htmlspecialchars($app['path']) ?>" class="block">
              <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-center p-6 rounded-lg shadow hover:shadow-lg transition">
                <i class="<?= $app['icon'] ?> text-4xl mb-4 text-gray-700 dark:text-gray-300"></i>
                <p class="text-gray-800 dark:text-gray-200 font-bold text-lg"><?= htmlspecialchars($app['name']) ?></p>
                <div class="h-[4px] bg-green-600 mt-4"></div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php
  }

  public static function renderUserEditionPanel($user)
  {
  ?>
    <div class="md:col-span-3 p-4 rounded-lg shadow-md bg-white dark:bg-gray-800">
      <h2 class="text-xl font-bold">Painel de Edição</h2>
      <form class="mt-4" action="methods/handlers/editUser.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" name="id" value="<?php echo $user['id']; ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="name" class="block text-gray-700 dark:text-gray-300">Nome</label>
            <input type="text" id="name" name="name"
              value="<?php echo htmlspecialchars($user['name']); ?>"
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
          </div>
          <div>
            <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" id="email" name="email"
              value="<?php echo htmlspecialchars($user['email']); ?>"
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
          </div>
          <div>
            <label for="password" class="block text-gray-700 dark:text-gray-300">Senha</label>
            <input type="password" id="password" name="password"
              value=""
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
          </div>
          <div>
            <label for="role" class="block text-gray-700 dark:text-gray-300">Cargo</label>
            <select type="role" id="role" name="role" class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
              <option value="aluno" <?php echo ($user['role'] === 'aluno') ? 'selected' : ''; ?>>Aluno(a)</option>
              <option value="gremio" <?php echo ($user['role'] === 'gremio') ? 'selected' : ''; ?>>Grêmio</option>
              <option value="professor" <?php echo ($user['role'] === 'professor') ? 'selected' : ''; ?>>Professor(a)</option>
              <option value="gestao" <?php echo ($user['role'] === 'gestao') ? 'selected' : ''; ?>>Gestão</option>
            </select>

          </div>
        </div>

        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
          Salvar Alterações
        </button>
      </form>
    </div>
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
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">E.E.E.P Professora Elsa Maria Porto Costa Lima</span>
        </div>
      </div>
    </footer>
<?php
  }
}
