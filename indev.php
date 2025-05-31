<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Em Desenvolvimento - E.E.E.P. Profª Elsa Maria Porto Costa Lima</title>
  <link rel="shortcut icon" href="public/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300 min-h-screen flex flex-col">
  <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center">
          <img src="public/images/logo.svg" alt="EP Aracati Logo" class="h-10 w-auto mr-3">
          <span class="font-bold text-xl text-green-600 dark:text-green-400">EP Aracati</span>
        </div>

        <div class="hidden md:flex items-center space-x-8">
          <nav class="flex space-x-6">
            <a href="index.php" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Voltar ao Início</a>
          </nav>

          <div class="flex items-center space-x-4">
            <button onclick="toggleDarkMode()" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
            </button>
            <a href="app/login.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
              <i class="fas fa-sign-in-alt mr-2"></i> Entrar
            </a>
          </div>
        </div>

        <div class="md:hidden flex items-center">
          <button id="mobile-menu-button" class="p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <div id="mobile-menu" class="hidden md:hidden pb-4">
        <div class="flex flex-col space-y-3">
          <a href="index.php" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Voltar ao Início</a>
          <a href="app/login.php" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
            <i class="fas fa-sign-in-alt mr-2"></i> Entrar
          </a>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full">
      <div class="relative bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-500 rounded-3xl overflow-hidden shadow-2xl p-8 md:p-12 group">
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>
        <div class="absolute -top-6 -left-6 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full h-full bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>

        <div class="relative z-10 text-center">
          <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white/20 mb-6 mx-auto animate-pulse-slow">
            <i class="fas fa-tools text-white text-4xl"></i>
          </div>

          <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">
            <span class="block">Página em</span>
            <span class="block animated-gradient bg-clip-text">Desenvolvimento</span>
          </h1>

          <div class="h-2 w-32 mx-auto bg-white/30 rounded-full mb-8"></div>

          <p class="text-blue-50 text-lg md:text-xl font-medium max-w-2xl mx-auto mb-8 leading-relaxed">
            Estamos trabalhando para trazer uma experiência incrível para você. Esta seção estará disponível em breve com novos recursos e funcionalidades.
          </p>

          <div class="flex flex-wrap justify-center gap-4 mb-8">
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full text-white">
              <i class="fas fa-code text-blue-200"></i>
              <span>Desenvolvimento</span>
            </div>
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full text-white">
              <i class="fas fa-paint-brush text-blue-200"></i>
              <span>Design</span>
            </div>
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full text-white">
              <i class="fas fa-cogs text-blue-200"></i>
              <span>Configuração</span>
            </div>
          </div>

          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="index.php" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 text-lg font-bold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:bg-blue-50">
              <i class="fas fa-home"></i>
              <span>Voltar ao Início</span>
            </a>
            <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/40 text-white text-lg font-bold rounded-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
              <i class="fas fa-sign-in-alt"></i>
              <span>Voltar</span>
            </a>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('hidden');
    });

    function toggleDarkMode() {
      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.theme = 'light';
      } else {
        document.documentElement.classList.add('dark');
        localStorage.theme = 'dark';
      }
    }

    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }
  </script>
</body>

</html>