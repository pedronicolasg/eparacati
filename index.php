<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E.E.E.P. Profª Elsa Maria Porto Costa Lima</title>
  <link rel="shortcut icon" href="public/assets/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="public/assets/css/style.css">
  <style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&display=swap');

    body {
      font-family: "Exo", sans-serif;
    }

    .hero-pattern {
      background-color: #ffffff;
      background-image: url("public/assets/images/landingpage/background.svg");
    }

    .dark .hero-pattern {
      background-color: #0f172a;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
  <header class="sticky top-0 z-50 bg-white dark:bg-gray-800 shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center">
          <img src="public/assets/images/logo.svg" alt="EP Aracati Logo" class="h-10 w-auto mr-3">
          <span class="font-bold text-xl text-green-600 dark:text-green-400">EP Aracati</span>
        </div>

        <div class="hidden md:flex items-center space-x-8">
          <nav class="flex space-x-6">
            <a href="#inicio" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Início</a>
            <a href="#sobre" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Sobre</a>
            <a href="#cursos" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Cursos</a>
            <a href="#estrutura" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Estrutura</a>
            <a href="#depoimentos" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Depoimentos</a>
            <a href="#contato" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Contato</a>
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
            <a href="app/" class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300">Área do Usuário</a>
          </div>
        </div>

        <div class="md:hidden flex items-center">
          <button onclick="toggleDarkMode()" class="p-2 mr-4 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
          </button>
          <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>

      <div id="mobile-menu" class="md:hidden hidden pb-4">
        <nav class="flex flex-col space-y-3">
          <a href="#inicio" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Início</a>
          <a href="#sobre" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Sobre</a>
          <a href="#cursos" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Cursos</a>
          <a href="#estrutura" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Estrutura</a>
          <a href="#depoimentos" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Depoimentos</a>
          <a href="#contato" class="text-gray-700 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 font-medium">Contato</a>
          <a href="#" class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300 w-full text-center mt-2">Área do Aluno</a>
        </nav>
      </div>
    </div>
  </header>

  <section id="inicio" class="hero-pattern py-16 md:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0 md:pr-10">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-4">
            Educação de Qualidade em <span class="text-green-600 dark:text-green-400">Aracati</span>
          </h1>
          <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            Há mais de 15 anos formando cidadãos e profissionais preparados para os desafios do mundo moderno, com valores éticos e compromisso com a excelência.
          </p>
          <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="#cursos" class="px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-md transition-colors duration-300 text-center">
              Conheça Nossos Cursos
            </a>
            <a href="#contato" class="px-6 py-3 bg-white hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 text-green-600 dark:text-green-400 font-medium rounded-md shadow-md border border-gray-200 dark:border-gray-700 transition-colors duration-300 text-center">
              Agende uma Visita
            </a>
          </div>
        </div>
        <div class="md:w-1/2">
          <img src="public/assets/images/landingPage/banner.png" alt="EP Aracati Campus" class="rounded-lg shadow-xl w-full h-auto">
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white dark:bg-gray-800 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-green-600 dark:text-green-400 text-4xl font-bold mb-2">460+</div>
          <div class="text-gray-700 dark:text-gray-300 font-medium">Alunos Matriculados</div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-green-600 dark:text-green-400 text-4xl font-bold mb-2">15+</div>
          <div class="text-gray-700 dark:text-gray-300 font-medium">Professores Qualificados</div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-green-600 dark:text-green-400 text-4xl font-bold mb-2">16</div>
          <div class="text-gray-700 dark:text-gray-300 font-medium">Anos de Tradição</div>
        </div>
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md text-center">
          <div class="text-green-600 dark:text-green-400 text-4xl font-bold mb-2">XX%</div>
          <div class="text-gray-700 dark:text-gray-300 font-medium">Aprovação em Vestibulares</div>
        </div>
      </div>
    </div>
  </section>

  <section id="sobre" class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0">
          <img src="public/assets/images/logo.svg" alt="Sobre EP Aracati" class="rounded-lg shadow-xl w-full h-auto">
        </div>
        <div class="md:w-1/2 md:pl-10">
          <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">Sobre a EP Aracati</h2>
          <p class="text-lg text-gray-700 dark:text-gray-300 mb-6">
            Fundada em 20XX, a Escola Profissionalizante de Aracati (EP Aracati) é uma instituição de ensino comprometida com a formação integral de seus alunos, combinando excelência acadêmica, valores éticos e preparação para o mercado de trabalho.
          </p>
          <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            Nossa missão é formar cidadãos críticos, éticos e preparados para os desafios do século XXI, contribuindo para o desenvolvimento sustentável da região de Aracati e do estado do Ceará.
          </p>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700 dark:text-gray-300">Ensino de qualidade</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700 dark:text-gray-300">Professores especializados</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700 dark:text-gray-300">Infraestrutura moderna</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-gray-700 dark:text-gray-300">Formação integral</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="cursos" class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Nossos Cursos</h2>
        <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
          Oferecemos uma variedade de cursos técnicos e profissionalizantes para preparar nossos alunos para o mercado de trabalho e para o ensino superior.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- ENFER -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <img src="public/assets/images/landingPage/cursos/ENFER.png" alt="Técnico em Enfermagem" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Técnico em Enfermagem</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Duração: XX meses</span>
            </div>
            <a href="#" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300">
              Saiba Mais
            </a>
          </div>
        </div>

        <!-- GUIA -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <img src="public/assets/images/landingPage/cursos/GUIA.png" alt="Guia de Turismo" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Guia de Turismo</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Duração: XX meses</span>
            </div>
            <a href="#" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300">
              Saiba Mais
            </a>
          </div>
        </div>

        <!-- INFOR -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <img src="public/assets/images/landingPage/cursos/INFOR.png" alt="Técnico em Administração" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Técnico em Informática</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Duração: XX meses</span>
            </div>
            <a href="#" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300">
              Saiba Mais
            </a>
          </div>
        </div>

        <!-- S.E.R -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <img src="public/assets/images/landingPage/cursos/SER.png" alt="Técnico em Sistemas de Energias Renováveis" class="w-full h-48 object-cover">
          <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Técnico em Sistemas de Energias Renováveis</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-4">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula.
            </p>
            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Duração: XX meses</span>
            </div>
            <a href="#" class="inline-block px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-sm transition-colors duration-300">
              Saiba Mais
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="estrutura" class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Nossa Estrutura</h2>
        <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
          Contamos com instalações modernas e equipamentos de última geração para proporcionar a melhor experiência de aprendizado aos nossos alunos.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Laboratórios de Informática</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Equipados com computadores modernos, softwares atualizados e acesso à internet de alta velocidade para aulas práticas e projetos.
          </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Biblioteca</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Amplo acervo de livros, revistas e materiais didáticos, além de espaços para estudo individual e em grupo.
          </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Laboratórios de Ciências</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Espaços equipados para aulas práticas de física, química e biologia, com materiais e instrumentos modernos.
          </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Quadra Poliesportiva</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Espaço para prática de esportes, atividades físicas e eventos escolares, promovendo saúde e integração.
          </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Auditório</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Espaço para palestras, apresentações, eventos culturais e formaturas, com capacidade para 200 pessoas.
          </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition-transform duration-300 hover:transform hover:scale-105">
          <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Salas Climatizadas</h3>
          <p class="text-gray-700 dark:text-gray-300">
            Todas as salas de aula são equipadas com ar-condicionado, projetores multimídia e mobiliário ergonômico.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section id="depoimentos" class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">O Que Dizem Sobre Nós</h2>
        <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
          Conheça a opinião de alunos, pais e professores sobre a experiência na EP Aracati.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-6">
          <div class="flex items-center mb-4">
            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden mr-4">
              <img src="https://avatar.iran.liara.run/public/boy" alt="Avatar" class="h-full w-full object-cover">
            </div>
            <div>
              <h4 class="font-semibold text-gray-900 dark:text-white">NOME</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">Ex-aluno</p>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300 italic">
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula. In at consectetur massa, ac semper mi. Mauris congue non nibh ut pretium."
          </p>
          <div class="mt-4 flex text-green-500 dark:text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-6">
          <div class="flex items-center mb-4">
            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden mr-4">
              <img src="https://avatar.iran.liara.run/public/boy" alt="Avatar" class="h-full w-full object-cover">
            </div>
            <div>
              <h4 class="font-semibold text-gray-900 dark:text-white">NOME</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">Ex-aluno</p>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300 italic">
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula. In at consectetur massa, ac semper mi. Mauris congue non nibh ut pretium."
          </p>
          <div class="mt-4 flex text-green-500 dark:text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-6">
          <div class="flex items-center mb-4">
            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-600 overflow-hidden mr-4">
              <img src="https://avatar.iran.liara.run/public/boy" alt="Avatar" class="h-full w-full object-cover">
            </div>
            <div>
              <h4 class="font-semibold text-gray-900 dark:text-white">NOME</h4>
              <p class="text-sm text-gray-600 dark:text-gray-400">Ex-aluno</p>
            </div>
          </div>
          <p class="text-gray-700 dark:text-gray-300 italic">
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque nisl, semper at commodo nec, finibus et ligula. In at consectetur massa, ac semper mi. Mauris congue non nibh ut pretium."
          </p>
          <div class="mt-4 flex text-green-500 dark:text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 bg-green-600 dark:bg-green-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Pronto para fazer parte da EP Aracati?</h2>
      <p class="text-lg text-white/90 mb-8 max-w-3xl mx-auto">
        Junte-se a nós e faça parte de uma comunidade educacional comprometida com a excelência e o desenvolvimento integral dos alunos.
      </p>
      <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="#" class="px-8 py-3 bg-white hover:bg-gray-100 text-green-600 font-medium rounded-md shadow-md transition-colors duration-300">
          Agendar Visita
        </a>
        <a href="#" class="px-8 py-3 bg-green-700 hover:bg-green-800 dark:bg-green-900 dark:hover:bg-green-950 text-white font-medium rounded-md shadow-md border border-green-500 transition-colors duration-300">
          Processo Seletivo
        </a>
      </div>
    </div>
  </section>

  <section id="contato" class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Entre em Contato</h2>
        <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
          Estamos à disposição para esclarecer suas dúvidas e fornecer mais informações sobre nossa instituição.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div>
          <form class="space-y-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome Completo</label>
              <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
              <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assunto</label>
              <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div>
              <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mensagem</label>
              <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <div>
              <button type="submit" class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white font-medium rounded-md shadow-md transition-colors duration-300">
                Enviar Mensagem
              </button>
            </div>
          </form>
        </div>

        <div class="space-y-8">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informações de Contato</h3>
            <div class="space-y-4">
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white">Endereço</h4>
                  <p class="text-gray-700 dark:text-gray-300">R. José de Alençar, 1930 - N Sr de Lourdes, Aracati - CE, 62800-000</p>
                </div>
              </div>
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white">Telefone</h4>
                  <p class="text-gray-700 dark:text-gray-300">(88) XXXXX-XXXX</p>
                </div>
              </div>
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <div>
                  <h4 class="font-medium text-gray-900 dark:text-white">Email</h4>
                  <p class="text-gray-700 dark:text-gray-300">xxxxxxx@xxxxx.xxx</p>
                </div>
              </div>
            </div>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Horário de Atendimento</h3>
            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
              <li class="flex justify-between">
                <span>Segunda - Sexta:</span>
                <span>7:30 - 17:00</span>
              </li>
              <li class="flex justify-between">
                <span>Sábado & Domingo:</span>
                <span>Fechado</span>
              </li>
            </ul>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Redes Sociais</h3>
            <div class="flex space-x-4">
              <a href="https://www.facebook.com/eeparacati/" class="text-gray-600 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                </svg>
              </a>
              <a href="https://www.instagram.com/eparacati/" class="text-gray-600 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center mb-4">
            <img src="public/assets/images/logo.svg" alt="EP Aracati Logo" class="h-10 w-auto mr-3">
            <span class="font-bold text-xl text-green-600 dark:text-green-400">EP Aracati</span>
          </div>
          <p class="text-gray-700 dark:text-gray-400 mb-4">
            Transformando vidas através da educação de qualidade em Aracati.
          </p>
          <div class="flex space-x-4">
            <a href="https://www.facebook.com/eeparacati/" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
              </svg>
            </a>
            <a href="https://www.instagram.com/eparacati/" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>
          </div>
        </div>

        <div>
          <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Links Rápidos</h3>
          <ul class="space-y-2">
            <li><a href="#inicio" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Início</a></li>
            <li><a href="#sobre" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Sobre</a></li>
            <li><a href="#cursos" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Cursos</a></li>
            <li><a href="#estrutura" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Estrutura</a></li>
            <li><a href="#depoimentos" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Depoimentos</a></li>
            <li><a href="#contato" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Contato</a></li>
          </ul>
        </div>

        <div>
          <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Cursos</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Técnico em Enfermagem</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Guia de Turismo</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Técnico em Informática</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Técnico em S.E.R.</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Preparatório ENEM</a></li>
          </ul>
        </div>

        <div>
          <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-4">Informações</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Processo Seletivo</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Calendário Acadêmico</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Notícias e Eventos</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Área do Aluno</a></li>
            <li><a href="#" class="text-gray-700 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">Trabalhe Conosco</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-200 dark:border-gray-800 mt-10 pt-8 text-center text-gray-700 dark:text-gray-400">
        <p>&copy; 2025 E.E.E.P. Profª Elsa Maria Porto Costa Lima.</p>
        <p class="text-green-500 hover:text-green-600 dark:text-green-400 dark:hover:text-green-500">Desenvolvido por <a target="_blank" href="https://www.notion.so/Cr-ditos-1b060ff25303805eb9b3c64bf8521ae1?pvs=4" class="text-red-400 hover:text-red-500">Cyclone Team</a></p>
      </div>
    </div>
  </footer>

  <script src="public/assets/js/landingPage.js"></script>
</body>

</html>