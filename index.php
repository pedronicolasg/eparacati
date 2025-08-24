<!DOCTYPE html>
<html lang="pt_BR" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E.E.E.P. Profª Elsa Maria Porto Costa Lima</title>
  <link rel="shortcut icon" href="public/images/logo.svg" type="image/x-icon">
  <link href="public/css/output.css" rel="stylesheet">
  <link href="public/assets/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="public/assets/fontawesome/css/all.min.css" rel="stylesheet" />

</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 transition-colors duration-300">
  <nav class="fixed top-0 w-full z-50 bg-white/90 dark:bg-slate-900/90 backdrop-blur-lg border-b border-slate-200/20 dark:border-slate-700/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-2 flex-shrink-0">
          <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center">
            <img src="public/images/logo.svg" alt="EEEP Aracati logo" class="w-8 h-8 lg:w-10 lg:h-10 rounded-lg">
          </div>
          <span class="text-sm sm:text-lg lg:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">EEEP Aracati</span>
        </div>

        <div class="hidden lg:flex items-center space-x-6">
          <a href="#home" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Home</a>
          <a href="#sobre" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Sobre</a>
          <a href="#estrutura" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Eventos</a>
          <a href="#cursos" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Cursos</a>
          <a href="#contato" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Contato</a>

          <button id="theme-toggle" class="p-2 rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
            <i class="fas fa-palette text-sm"></i>
          </button>

          <button onclick="window.location = 'app/'" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-all duration-300 animate-glow-green">
            <i class="fas fa-user mr-2"></i>
            Área do Usuário
          </button>
        </div>

        <div class="flex items-center space-x-2 lg:hidden">
          <button id="theme-toggle-mobile" class="p-2 rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
            <i class="fas fa-palette text-sm"></i>
          </button>

          <button id="mobile-menu-button" class="p-2 rounded-lg bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 transition-all duration-300">
            <i id="menu-icon" class="fas fa-bars text-lg"></i>
          </button>
        </div>
      </div>
    </div>

    <div id="mobile-menu" class="lg:hidden absolute top-full left-0 right-0 bg-white/95 dark:bg-slate-900/95 backdrop-blur-lg border-b border-slate-200/20 dark:border-slate-700/20 transform translate-y-0 opacity-100 transition-all duration-300 ease-out hidden">
      <div class="px-4 py-6 space-y-2">
        <a href="#home" class="mobile-menu-link block py-3 px-4 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
          <i class="fas fa-home mr-3 w-5 text-center"></i>Home
        </a>
        <a href="#sobre" class="mobile-menu-link block py-3 px-4 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
          <i class="fas fa-info-circle mr-3 w-5 text-center"></i>Sobre
        </a>
        <a href="#estrutura" class="mobile-menu-link block py-3 px-4 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
          <i class="fas fa-building mr-3 w-5 text-center"></i>Estrutura
        </a>
        <a href="#cursos" class="mobile-menu-link block py-3 px-4 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
          <i class="fas fa-graduation-cap mr-3 w-5 text-center"></i>Cursos
        </a>
        <a href="#contato" class="mobile-menu-link block py-3 px-4 text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
          <i class="fas fa-envelope mr-3 w-5 text-center"></i>Contato
        </a>

        <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
          <button onclick="window.location = 'app/'" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-semibold transition-all duration-300 animate-glow-green">
            <i class="fas fa-user mr-2"></i>
            Área do Usuário
          </button>
        </div>
      </div>
    </div>
  </nav>

  <section id="home" class="relative min-h-screen flex items-center overflow-hidden pt-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-slate-900 dark:via-emerald-900/20 dark:to-teal-900/20"></div>

    <div class="absolute top-20 left-4 w-16 h-16 bg-emerald-500/20 rounded-full blur-xl animate-float"></div>
    <div class="absolute bottom-20 right-4 w-24 h-24 bg-teal-500/20 rounded-full blur-xl animate-float" style="animation-delay: -3s;"></div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
        <div class="space-y-6 text-center lg:text-left order-2 lg:order-1">
          <div class="space-y-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
              <span class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">E.E.E.P. Profª</span>
              <br>
              <span class="text-slate-900 dark:text-slate-100">Elsa Maria Porto Costa Lima</span>
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
              Há mais de 15 anos formando cidadãos e profissionais preparados para os desafios
              do mundo moderno, com valores éticos e compromisso com a excelência.
            </p>
          </div>

          <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
            <button onclick="window.location = '#cursos'" class="px-6 py-3 sm:px-8 sm:py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-300 animate-glow">
              <i class="fas fa-graduation-cap mr-2"></i>
              Nossos cursos
            </button>
            <button onclick="window.location = '#contato'" class="px-6 py-3 sm:px-8 sm:py-4 bg-white/20 dark:bg-slate-800/50 backdrop-blur-lg border border-white/30 dark:border-slate-700/50 rounded-xl font-semibold hover:bg-white/30 dark:hover:bg-slate-700/50 transition-all duration-300">
              <i class="fas fa-plus mr-2"></i>
              Agende uma visita
            </button>
          </div>
        </div>

        <div class="relative order-1 lg:order-2">
          <div class="swiper hero-swiper rounded-2xl overflow-hidden shadow-2xl">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="public/images/landingpage/carousel1.png" alt="Vivência Nordestina IX 2024" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                  <h3 class="text-lg font-semibold">Vivência Nordestina IX</h3>
                  <p class="text-sm opacity-90">2024</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="public/images/landingpage/carousel2.jpg" alt="STS24 INF1 2024" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                  <h3 class="text-lg font-semibold">Siará Tech Summit 2024</h3>
                  <p class="text-sm opacity-90">Visita técnica da turm de Informática 1 (2024)</p>
                </div>
              </div>
              <div class="swiper-slide">
                <img src="public/images/landingpage/carousel3.jpg" alt="Feira da Profissões 2024" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <div class="absolute bottom-4 left-4 text-white">
                  <h3 class="text-lg font-semibold">Feira das Profissões 2024</h3>
                  <p class="text-sm opacity-90">Oficina de robótica feita pelas turma de Informática 1 e 2 (2024)</p>
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>

          <div class="absolute -bottom-4 -right-4 w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 bg-white/20 dark:bg-slate-800/30 backdrop-blur-lg rounded-2xl border border-white/30 dark:border-slate-700/30 flex items-center justify-center">
            <div class="text-center">
              <div class="text-lg sm:text-xl lg:text-2xl font-bold text-emerald-600">
                <?= date('Y') - 2009 ?>+
              </div>
              <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Anos</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-12 lg:py-20 bg-white/50 dark:bg-slate-800/50 backdrop-blur-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        <div class="text-center group">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-users text-white text-lg lg:text-xl"></i>
          </div>
          <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 dark:text-slate-100">450+</div>
          <div class="text-sm lg:text-base text-slate-600 dark:text-slate-400">Alunos</div>
        </div>
        <div class="text-center group">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-chalkboard-teacher text-white text-lg lg:text-xl"></i>
          </div>
          <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 dark:text-slate-100">20+</div>
          <div class="text-sm lg:text-base text-slate-600 dark:text-slate-400">Professores</div>
        </div>
        <div class="text-center group">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-book text-white text-lg lg:text-xl"></i>
          </div>
          <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 dark:text-slate-100">4</div>
          <div class="text-sm lg:text-base text-slate-600 dark:text-slate-400">Cursos</div>
        </div>
        <div class="text-center group">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-3 lg:mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-trophy text-white text-lg lg:text-xl"></i>
          </div>
          <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900 dark:text-slate-100">XX%</div>
          <div class="text-sm lg:text-base text-slate-600 dark:text-slate-400">Taxa de aprovação</div>
        </div>
      </div>
    </div>
  </section>

  <section id="sobre" class="py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">
        <div class="space-y-6 lg:space-y-8 order-2 lg:order-1">
          <div class="space-y-4">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100">Sobre nós</h2>
            <p class="text-base lg:text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
              Fundada em 2009, a Escola Profissionalizante de Aracati (EP Aracati) é uma
              instituição de ensino comprometida com a formação integral de seus alunos,
              combinando excelência acadêmica, valores éticos e preparação para o mercado de
              trabalho.
            </p>
          </div>

          <div class="space-y-4 lg:space-y-6">
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-lightbulb text-emerald-600"></i>
              </div>
              <div>
                <h3 class="text-lg lg:text-xl font-semibold text-slate-900 dark:text-slate-100">Ensino de qualidade</h3>
              </div>
            </div>
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-chalkboard-teacher text-blue-600"></i>
              </div>
              <div>
                <h3 class="text-lg lg:text-xl font-semibold text-slate-900 dark:text-slate-100">Professores especializados</h3>
              </div>
            </div>
            <div class="flex items-start space-x-4">
              <div class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-purple-600"></i>
              </div>
              <div>
                <h3 class="text-lg lg:text-xl font-semibold text-slate-900 dark:text-slate-100">Formação integral</h3>
              </div>
            </div>
          </div>
        </div>

        <div class="relative order-1 lg:order-2">
          <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-3xl blur-3xl"></div>
          <div class="relative bg-white/20 dark:bg-slate-800/30 backdrop-blur-lg rounded-3xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30">
            <img src="public/images/landingpage/aboutus.jpg" alt="EEEP Aracati" class="w-full h-48 lg:h-64 object-cover rounded-2xl mb-4 lg:mb-6">
            <div class="space-y-4">
              <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100">Nossa missão</h3>
              <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400">
                Nossa missão é formar cidadãos críticos, éticos e preparados para os desafios do
                século XXI, contribuindo para o desenvolvimento sustentável da região de Aracati e
                do estado do Ceará.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="estrutura" class="py-12 lg:py-20 bg-slate-50 dark:bg-slate-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 lg:mb-16">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100 mb-4">Nossa Estrutura</h2>
        <p class="text-base lg:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
          Contamos com instalações e equipamentos para proporcionar a melhor experiência de aprendizado aos nossos alunos
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-laptop-code text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Laboratório de Informática</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Equipados com computadores modernos, softwares atualizados e acesso à internet de alta velocidade para aulas práticas e projetos.
          </p>
        </div>

        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-book text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Biblioteca</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Amplo acervo de livros, revistas e materiais didáticos, além de espaços para estudo individuale em grupo.
          </p>
        </div>

        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300 md:col-span-2 lg:col-span-1">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-flask text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Laboratório Técnicos</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Espaços equipados para aulas práticas de física, química e biologia, com materiais e instrumentos modernos.
          </p>
        </div>

        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-futbol text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Quadra Poliesportiva</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Espaço para prática de esportes, atividades físicas e eventos escolares, promovendo saúde e integração.
          </p>
        </div>

        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-bullhorn text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Auditório</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Espaço para palestras, apresentações, eventos culturais e formaturas, com capacidade para 200 pessoas.
          </p>
        </div>

        <div class="group bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300 md:col-span-2 lg:col-span-1">
          <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 lg:mb-6 group-hover:animate-glow">
            <i class="fas fa-snowflake text-white text-lg lg:text-xl"></i>
          </div>
          <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 lg:mb-4">Salas Climatizadas</h3>
          <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4 lg:mb-6">
            Todas as salas de aula são equipadas com ar condicionado, projetores multimídia e mobiliário ergonômico.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="cursos" class="py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 lg:mb-16">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100 mb-4">Nossos Cursos</h2>
        <p class="text-base lg:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
          Oferecemos uma variedade de cursos técnicos e profissionalizantes para preparar nossos alunos para o mercado de trabalho e para o ensino superior.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        <!--ENFER-->
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl overflow-hidden border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <img src="public/images/landingpage/cursos/ENFER.png" alt="Curso Técnico em Enfermagem" class="w-full h-40 lg:h-48 object-cover">
          <div class="p-4 lg:p-6">
            <div class="flex items-center space-x-2 text-emerald-600 dark:text-emerald-400 text-sm font-semibold mb-2">
              <i class="fas fa-clock"></i>
              <span>xxH</span>
            </div>
            <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">Técnico em Enfermagem</h3>
            <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <button class="text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
              Saiba mais <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!--GUIA-->
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl overflow-hidden border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <img src="public/images/landingpage/cursos/GUIA.png" alt="Curso Técnico em Guia de Turismo" class="w-full h-40 lg:h-48 object-cover">
          <div class="p-4 lg:p-6">
            <div class="flex items-center space-x-2 text-emerald-600 dark:text-emerald-400 text-sm font-semibold mb-2">
              <i class="fas fa-clock"></i>
              <span>xxH</span>
            </div>
            <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">Técnico em Guia de Turismo</h3>
            <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <button class="text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
              Saiba mais <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!--INFOR-->
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl overflow-hidden border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <img src="public/images/landingpage/cursos/INFOR.png" alt="Curso Técnico em Informática" class="w-full h-40 lg:h-48 object-cover">
          <div class="p-4 lg:p-6">
            <div class="flex items-center space-x-2 text-emerald-600 dark:text-emerald-400 text-sm font-semibold mb-2">
              <i class="fas fa-clock"></i>
              <span>xxH</span>
            </div>
            <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">Técnico em Informática</h3>
            <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <button class="text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
              Saiba mais <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!-- S.E.R. -->
        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl overflow-hidden border border-white/30 dark:border-slate-700/30 hover:transform hover:scale-105 transition-all duration-300">
          <img src="public/images/landingpage/cursos/SER.png" alt="Curso Técnico em Sistema de Energias Renováveis" class="w-full h-40 lg:h-48 object-cover">
          <div class="p-4 lg:p-6">
            <div class="flex items-center space-x-2 text-emerald-600 dark:text-emerald-400 text-sm font-semibold mb-2">
              <i class="fas fa-clock"></i>
              <span>xxH</span>
            </div>
            <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-slate-100 mb-2">Técnico em Sistema de Energias Renováveis</h3>
            <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400 mb-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <button class="text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
              Saiba mais <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="contato" class="py-12 lg:py-20 bg-slate-50 dark:bg-slate-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 lg:mb-16">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-900 dark:text-slate-100 mb-4">Entre em contato</h2>
        <p class="text-base lg:text-xl text-slate-600 dark:text-slate-400 max-w-3xl mx-auto"> Estamos à disposição para esclarecer suas dúvidas e fornecer mais informações sobre nossa instituição.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
        <div class="space-y-6 lg:space-y-8">
          <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30">
            <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4 lg:mb-6">Contato</h3>
            <div class="space-y-4 lg:space-y-6">
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-map-marker-alt text-emerald-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-slate-900 dark:text-slate-100">Endereço</h4>
                  <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400">R. José de Alençar, 1930 - N Sr de Lourdes, Aracati - CE, 62800-000</p>
                </div>
              </div>
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-phone text-blue-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-slate-900 dark:text-slate-100">Tel.</h4>
                  <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400">+55 (88) 9381-4360</p>
                </div>
              </div>
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-envelope text-purple-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-slate-900 dark:text-slate-100">Email</h4>
                  <p class="text-sm lg:text-base text-slate-600 dark:text-slate-400">xxxx@xxx.com</p>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30">
            <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-slate-100 mb-4 lg:mb-6">Horário de Atendimento
            </h3>
            <div class="space-y-3">
              <div class="flex justify-between">
                <span class="text-slate-600 dark:text-slate-400">Segunda - Sexta</span>
                <span class="font-semibold text-slate-900 dark:text-slate-100">7:30 - 17:00</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-600 dark:text-slate-400">Sábado & Domingo</span>
                <span class="font-semibold text-slate-900 dark:text-slate-100">Fechado</span>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white/60 dark:bg-slate-800/60 backdrop-blur-lg rounded-2xl p-6 lg:p-8 border border-white/30 dark:border-slate-700/30">
          <form class="space-y-4 lg:space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
              <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Primeiro Nome</label>
                <input type="text" class="w-full px-3 lg:px-4 py-2 lg:py-3 bg-white/50 dark:bg-slate-700/50 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300">
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Sobrenome</label>
                <input type="text" class="w-full px-3 lg:px-4 py-2 lg:py-3 bg-white/50 dark:bg-slate-700/50 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300">
              </div>
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Email</label>
              <input type="email" class="w-full px-3 lg:px-4 py-2 lg:py-3 bg-white/50 dark:bg-slate-700/50 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300">
            </div>
            <div>
              <label class="block text-sm font-semibold text-slate-900 dark:text-slate-100 mb-2">Mensagem</label>
              <textarea rows="4" class="w-full px-3 lg:px-4 py-2 lg:py-3 bg-white/50 dark:bg-slate-700/50 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-300"></textarea>
            </div>
            <button type="submit" class="w-full px-6 lg:px-8 py-3 lg:py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-lg font-semibold hover:from-emerald-700 hover:to-teal-700 transform hover:scale-105 transition-all duration-300">
              <i class="fas fa-paper-plane mr-2"></i>
              Enviar
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-white dark:bg-slate-950 text-slate-900 dark:text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="space-y-4 sm:col-span-2 lg:col-span-1">
          <div class="flex items-center space-x-2">
            <img src="public/images/logo.svg" alt="EEEP Aracati logo" class="w-8 h-8 lg:w-10 lg:h-10 rounded-lg">
            <span class="text-lg lg:text-xl font-bold text-slate-900 dark:text-white">EEEP Aracati</span>
          </div>
          <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm lg:text-base">
            Transformando vidas através da educação de
            qualidade em Aracati.
          </p>
          <div class="flex space-x-4">
            <a href="https://www.facebook.com/eeparacati" class="w-8 h-8 lg:w-10 lg:h-10 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center hover:bg-blue-600 dark:hover:bg-blue-500 transition-colors">
              <i class="fab fa-facebook-f text-sm text-slate-900 dark:text-white"></i>
            </a>
            <a href="https://www.instagram.com/eparacati/" class="w-8 h-8 lg:w-10 lg:h-10 bg-slate-200 dark:bg-slate-700 rounded-lg flex items-center justify-center hover:bg-red-600 dark:hover:bg-red-500 transition-colors">
              <i class="fab fa-instagram text-sm text-slate-900 hover:text-white dark:text-white"></i>
            </a>
          </div>
        </div>

        <div>
          <h3 class="text-lg font-semibold mb-4 text-slate-900 dark:text-white">Links rápidos</h3>
          <ul class="space-y-2">
            <li><a href="#sobre" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Sobre nós</a></li>
            <li><a href="#estrutura" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Estrutura</a></li>
            <li><a href="#cursos" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Cursos</a></li>
            <li><a href="#contato" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Contato</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-lg font-semibold mb-4 text-slate-900 dark:text-white">Cursos Técnicos:</h3>
          <ul class="space-y-2">
            <li><a href="#cursos" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Informática</a></li>
            <li><a href="#cursos" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Enfermagem</a></li>
            <li><a href="#cursos" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Guia de Turismo</a></li>
            <li><a href="#cursos" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors text-sm lg:text-base">Sistemas de Energias Renováveis</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-lg font-semibold mb-4 text-slate-900 dark:text-white">Contato</h3>
          <div class="space-y-2">
            <p class="text-slate-600 dark:text-slate-300 text-sm lg:text-base">R. José de Alençar, 1930 - N Sr de Lourdes, Aracati - CE, 62800-000</p>
            <p class="text-slate-600 dark:text-slate-300 text-sm lg:text-base">+55 (88) 9381-4360</p>
            <p class="text-slate-600 dark:text-slate-300 text-sm lg:text-base"><a href="mailto:teste">XXXXXXX@XXXXX.XXX</a></p>
          </div>
        </div>
      </div>

      <div class="border-t border-slate-200 dark:border-slate-700 mt-8 lg:mt-12 pt-6 lg:pt-8 text-center">
        <p class="text-slate-600 dark:text-slate-300 text-sm font-bold lg:text-base">
          © <?= date('Y') ?> EEEP Profª Elsa Maria Porto Costa Lima.
        </p>
        <p class="text-slate-600 dark:text-slate-300 text-sm lg:text-base">
          Desenvolvido por: <a href="https://github.com/pedronicolasg" class="hover:text-emerald-600 dark:hover:text-emerald-300 transition-colors">Pedro Nícolas Gomes de Souza</a>
        </p>
      </div>
    </div>
  </footer>

  <script src="public/assets/swiper/swiper-bundle.min.js"></script>
  <script src="public/js/landingpage.js"></script>
  </script>
</body>

</html>