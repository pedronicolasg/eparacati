<?php
$allowUnauthenticatedAccess = true;
require_once 'app/src/bootstrap.php';

try {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE role = 'gestao'");
  $stmt->execute();
  $gestaoCount = $stmt->fetchColumn();

  $stmt = $conn->prepare("SELECT COUNT(*) FROM setupKeys WHERE active = 1");
  $stmt->execute();
  $availableKeysCount = $stmt->fetchColumn();

  if ($gestaoCount > 0 || $availableKeysCount == 0) {
    Navigation::redirect('app/login.php');
    exit;
  }
} catch (Exception $e) {
  Navigation::alert(
    'Erro no Servidor',
    'Não foi possível verificar as condições de acesso. Tente novamente mais tarde.',
    'error',
    'index.php'
  );
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EP Aracati - Configuração Inicial</title>
  <link rel="shortcut icon" href="public/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="public/css/output.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

  <style>
    @keyframes gradient-bg {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .animate-gradient-bg {
      background-size: 200% 200%;
      animation: gradient-bg 8s ease infinite;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white overflow-x-hidden">
  <?php UI::renderAlerts(true); ?>
  <div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute top-0 left-0 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-green-500/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-sky-700/5 rounded-full blur-3xl"></div>
  </div>

  <div id="main-content" class="relative min-h-screen flex flex-col items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-6xl mb-8 flex flex-col items-center">
      <div class="relative mb-6 animate-float">
        <div class="w-24 h-24 rounded-full flex items-center justify-center">
          <img src="public/images/logo.svg" alt="Logo" class="w-20 h-20 rounded-full object-cover" />
        </div>
        <div class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shadow-lg">
          <i class="fas fa-cog text-white text-sm"></i>
        </div>
      </div>

      <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-center mb-2 tracking-tight">
        <span class="bg-gradient-to-r from-sky-300 to-green-600 text-transparent bg-clip-text">EP Aracati</span>
      </h1>
      <p class="text-lg text-gray-300 font-light max-w-md text-center">
        <i class="fas fa-sparkles text-sky-400 mr-2"></i>Configuração Inicial do Sistema
      </p>

      <div class="w-full max-w-md mt-8 mb-2">
        <div class="flex items-center justify-between">
          <div class="text-xs text-gray-400">Passo <span id="current-step">1</span> de 3</div>
          <div class="text-xs text-gray-400" id="step-title">Ativação</div>
        </div>
        <div class="w-full h-1 mt-2 bg-gray-700/50 rounded-full overflow-hidden">
          <div id="progress-bar" class="h-full bg-gradient-to-r from-sky-500 to-green-500 rounded-full transition-all duration-500" style="width: 33.33%"></div>
        </div>
      </div>
    </div>

    <div class="w-full max-w-6xl bg-slate-900/40 backdrop-blur-xl rounded-3xl border border-white/10 shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-sky-500/20">
      <form id="setup-form" class="relative" action="app/src/controllers/setup/setup.php" method="POST" enctype="multipart/form-data">
        <!-- Passo 1: Chave de ativação -->
        <div id="step-1" class="step-content p-6 md:p-10 space-y-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-sky-500/20 flex items-center justify-center">
              <i class="fas fa-key text-sky-400"></i>
            </div>
            <h2 class="text-xl md:text-2xl font-semibold text-white">Ativação do Sistema</h2>
          </div>

          <div class="max-w-2xl mx-auto">
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-white/5 hover:border-sky-500/30 transition-all duration-300">
              <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-sky-500/20 mb-4">
                  <i class="fas fa-shield-alt text-sky-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">Bem-vindo ao EP Aracati</h3>
                <p class="text-gray-400">Digite sua chave de ativação para começar a configuração do sistema</p>
              </div>

              <label class="block text-gray-300 text-sm font-medium mb-2">Chave de Ativação</label>
              <div class="relative">
                <input type="text"
                  id="activation-key"
                  name="activation-key"
                  class="w-full bg-slate-900/80 border border-gray-700 rounded-xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all duration-300"
                  placeholder="Digite sua chave de ativação" />
                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                  <i class="fas fa-key text-yellow-400"></i>
                </div>
              </div>

              <div class="mt-6 text-center">
                <p class="text-sm text-gray-400 mb-2">Não tem uma chave de ativação?</p>
                <a href="mailto:nicolasdevcontato@gmail.com" class="text-sky-400 hover:text-sky-300 transition-colors text-sm">Entre em contato com o suporte</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Passo 2: Perfil do Gestor -->
        <div id="step-2" class="step-content hidden p-6 md:p-10 space-y-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
              <i class="fas fa-user text-green-400"></i>
            </div>
            <h2 class="text-xl md:text-2xl font-semibold text-white">Perfil do Administrador</h2>
          </div>

          <div class="bg-slate-800/50 rounded-2xl p-6 border border-white/5 hover:border-green-500/30 transition-all duration-300">
            <div class="mb-8 flex flex-col items-center">
              <div class="relative group">
                <div id="profile-preview" class="w-32 h-32 rounded-full bg-slate-900/80 border-2 border-dashed border-gray-600 flex items-center justify-center overflow-hidden group-hover:border-green-500/50 transition-all duration-300">
                  <i class="fas fa-user text-4xl text-gray-500 group-hover:text-green-400 transition-colors"></i>
                </div>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                  <div class="w-full h-full rounded-full bg-black/30 flex items-center justify-center">
                    <label for="profile-upload" class="cursor-pointer flex flex-col items-center">
                      <i class="fas fa-camera text-white text-xl mb-1"></i>
                      <span class="text-xs text-white">Alterar foto</span>
                    </label>
                  </div>
                </div>
                <input type="file" accept=".png, .jpeg, .jpg, .webp" id="profile-upload" name="profile_photo" class="hidden" />
              </div>
              <span class="text-sm text-gray-400 mt-3">Clique para adicionar sua foto</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Nome Completo*</label>
                <div class="relative">
                  <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fas fa-user"></i>
                  </div>
                  <input type="text"
                    name="name"
                    class="w-full bg-slate-900/80 border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all duration-300"
                    placeholder="Seu nome completo" />
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Email*</label>
                <div class="relative">
                  <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <input type="email"
                    name="email"
                    class="w-full bg-slate-900/80 border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all duration-300"
                    placeholder="email@exemplo.com" />
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Senha*</label>
                <div class="relative">
                  <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fas fa-lock"></i>
                  </div>
                  <input type="password"
                    name="password"
                    class="w-full bg-slate-900/80 border border-gray-700 rounded-xl pl-10 pr-10 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all duration-300"
                    placeholder="••••••••" />
                  <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer hover:text-gray-300">
                    <i class="fas fa-eye"></i>
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-gray-300 text-sm font-medium">Telefone*</label>
                <div class="relative">
                  <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fas fa-phone"></i>
                  </div>
                  <input type="tel"
                    name="phone"
                    class="w-full bg-slate-900/80 border border-gray-700 rounded-xl pl-10 pr-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all duration-300"
                    placeholder="(xx) xxxxx-xxxx" />
                </div>
              </div>
            </div>

            <div class="mt-6 space-y-2">
              <label class="block text-gray-300 text-sm font-medium">Biografia (opcional)</label>
              <div class="relative">
                <textarea
                  name="bio"
                  class="w-full bg-slate-900/80 border border-gray-700 rounded-xl p-4 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-500 transition-all duration-300 min-h-[100px]"
                  placeholder="Conte um pouco sobre você..."></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Passo 3: Dados Iniciais (Opcional) -->
        <div id="step-3" class="step-content hidden p-6 md:p-10 space-y-6">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
              <i class="fas fa-file-import text-green-400"></i>
            </div>
            <h2 class="text-xl md:text-2xl font-semibold text-white">Dados Iniciais (Opcional)</h2>
          </div>

          <div class="bg-slate-800/50 rounded-2xl p-6 border border-white/5 mb-6">
            <div class="text-center mb-6">
              <p class="text-gray-300">Você pode importar dados iniciais para o sistema ou pular esta etapa.</p>
              <p class="text-gray-400 text-sm">Todos os campos abaixo são opcionais.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-slate-800/70 rounded-2xl p-5 border border-white/5 hover:border-green-500/30 transition-all duration-300 group">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center">
                    <i class="fas fa-users text-green-400"></i>
                  </div>
                  <h3 class="font-medium text-white">Usuários Iniciais</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Importe uma planilha com os usuários iniciais do sistema.</p>
                <div class="file-upload-container">
                  <label class="relative block w-full">
                    <input type="file" accept=".csv, .xlsx" name="users_file" class="sr-only peer file-input" data-type="users" />
                    <div class="h-20 w-full border-2 border-dashed border-gray-600 peer-hover:border-green-500/50 rounded-xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 upload-area">
                      <i class="fas fa-cloud-upload text-gray-500 peer-hover:text-green-400 text-xl mb-1 transition-colors"></i>
                      <span class="text-xs text-gray-500 peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
                    </div>
                  </label>
                  <div class="file-info hidden mt-3 px-2"></div>
                </div>
              </div>

              <div class="bg-slate-800/70 rounded-2xl p-5 border border-white/5 hover:border-yellow-500/30 transition-all duration-300 group">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 rounded-full bg-yellow-500/20 flex items-center justify-center">
                    <i class="fas fa-laptop text-yellow-400"></i>
                  </div>
                  <h3 class="font-medium text-white">Equipamentos</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Importe uma planilha com os equipamentos iniciais.</p>
                <div class="file-upload-container">
                  <label class="relative block w-full">
                    <input type="file" accept=".csv, .xlsx" name="equipment_file" class="sr-only peer file-input" data-type="equipment" />
                    <div class="h-20 w-full border-2 border-dashed border-gray-600 peer-hover:border-yellow-500/50 rounded-xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 upload-area">
                      <i class="fas fa-cloud-upload text-gray-500 peer-hover:text-yellow-400 text-xl mb-1 transition-colors"></i>
                      <span class="text-xs text-gray-500 peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
                    </div>
                  </label>
                  <div class="file-info hidden mt-3 px-2"></div>
                </div>
              </div>

              <div class="bg-slate-800/70 rounded-2xl p-5 border border-white/5 hover:border-purple-500/30 transition-all duration-300 group">
                <div class="flex items-center gap-3 mb-3">
                  <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-purple-400"></i>
                  </div>
                  <h3 class="font-medium text-white">Turmas</h3>
                </div>
                <p class="text-sm text-gray-400 mb-4">Importe uma planilha com as turmas iniciais.</p>
                <div class="file-upload-container">
                  <label class="relative block w-full">
                    <input type="file" accept=".csv, .xlsx" name="classes_file" class="sr-only peer file-input" data-type="classes" />
                    <div class="h-20 w-full border-2 border-dashed border-gray-600 peer-hover:border-purple-500/50 rounded-xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 upload-area">
                      <i class="fas fa-cloud-upload text-gray-500 peer-hover:text-purple-400 text-xl mb-1 transition-colors"></i>
                      <span class="text-xs text-gray-500 peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
                    </div>
                  </label>
                  <div class="file-info hidden mt-3 px-2"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-sky-500/10 border border-sky-500/20 rounded-xl p-4">
            <div class="flex items-start gap-3">
              <div class="text-sky-400 mt-1">
                <i class="fas fa-info-circle text-lg"></i>
              </div>
              <div>
                <h4 class="text-white font-medium">Dica para importação</h4>
                <p class="text-gray-300 text-sm">
                  Para facilitar a importação, baixe nossos modelos de planilha e preencha com seus dados antes de
                  fazer o upload.
                </p>
                <div class="mt-3 flex flex-wrap gap-3">
                  <a href="public/templates/spreadsheet/Modelo_Cadastro_Usuários.xlsx" download class="text-xs flex items-center gap-1 text-sky-400 hover:text-sky-300 transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Modelo de Usuários</span>
                  </a>
                  <a href="public/templates/spreadsheet/Modelo_Cadastro_Equipamentos.xlsx" download class="text-xs flex items-center gap-1 text-sky-400 hover:text-sky-300 transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Modelo de Equipamentos</span>
                  </a>
                  <a href="public/templates/spreadsheet/Modelo_Cadastro_Turmas.xlsx" download class="text-xs flex items-center gap-1 text-sky-400 hover:text-sky-300 transition-colors">
                    <i class="fas fa-download"></i>
                    <span>Modelo de Turmas</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="p-6 md:p-10 border-t border-white/10 flex justify-between">
          <button type="button" id="prev-btn" class="px-6 py-3 bg-slate-800 text-white rounded-xl flex items-center gap-2 transition-all duration-300 hover:bg-slate-700 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-slate-800">
            <i class="fas fa-arrow-left"></i>
            <span>Voltar</span>
          </button>

          <button type="button" id="next-btn" class="px-6 py-3 bg-gradient-to-r from-sky-500 to-green-500 text-white rounded-xl flex items-center gap-2 transition-all duration-300 hover:from-sky-600 hover:to-green-600 shadow-lg">
            <span>Próximo</span>
            <i class="fas fa-arrow-right"></i>
          </button>

          <button type="submit" id="submit-btn" class="hidden px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl flex items-center gap-2 transition-all duration-300 hover:from-green-600 hover:to-emerald-600 shadow-lg">
            <span>Finalizar Configuração</span>
            <i class="fas fa-check"></i>
          </button>
        </div>
      </form>
    </div>

    <div class="w-full max-w-6xl mt-8 text-center text-gray-500 text-sm">
      <p>&copy; 2025 E.E.E.P. Aracati. Desenvolvido por <a href="https://github.com/pedronicolasg" class="text-green-600 dark:text-green-700">Pedro Nícolas Gomes de Souza</a>.</p>

    </div>
  </div>

  <!-- Tela de Loading -->
  <div id="loading-screen" class="fixed inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex flex-col items-center justify-center hidden z-50 animate-gradient-bg">
    <img src="public/images/logo.svg" alt="Logo EP Aracati" class="w-64 h-64 mb-6 animate-pulse relative z-10" />
    <p id="loading-message" class="text-white text-xl font-semibold mb-4 relative z-10 drop-shadow-lg"></p>
    <span class="loader"></span>
  </div>

  <script src="public/js/setup.js"></script>
</body>

</html>