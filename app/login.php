<?php
require_once 'src/utils/Navigation.php';
@session_start();

if (isset($_SESSION['id'])) {
  Navigation::redirect('index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Login</title>
  <link rel="shortcut icon" href="../public/../public/assets/images/logo.svg" type="image/x-icon">
  <link rel="stylesheet" href="../public/../public/assets/css/style.css">
  <style>
    .glassmorphism {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.18);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }

    .input-focus:focus {
      box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.5);
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('../public/../public/assets/images/loginbackground.jpg');">
  <div class="glassmorphism p-8 rounded-2xl w-full max-w-md space-y-8 transition-all duration-300 hover:shadow-xl">
    <div class="text-center">
      <div class="mx-auto h-16 w-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center border border-white border-opacity-30">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
        </svg>
      </div>
      <h2 class="mt-6 text-3xl font-extrabold text-white tracking-tight">Login</h2>
      <p class="mt-2 text-sm text-white text-opacity-80">
        Entre com suas credenciais para acessar sua conta
      </p>
    </div>

    <form class="mt-8 space-y-6" action="src/handlers/user/login.php" method="POST">
      <div class="space-y-4 rounded-md">
        <div>
          <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <input id="email" name="email" type="email" required class="input-focus pl-10 w-full px-3 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg focus:outline-none text-white placeholder-white placeholder-opacity-70 transition-all duration-200" placeholder="seu@email.com">
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-white mb-2">Senha</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white text-opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input id="password" name="password" type="password" required class="input-focus pl-10 w-full px-3 py-3 bg-white bg-opacity-10 border border-white border-opacity-30 rounded-lg focus:outline-none text-white placeholder-white placeholder-opacity-70 transition-all duration-200" placeholder="••••••••">
          </div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="text-sm">
          <a href="#" class="font-medium text-green-400 hover:text-green-300 transition-colors duration-200">
            Esqueceu a senha?
          </a>
        </div>
      </div>

      <div>
        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 transform hover:-translate-y-1">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-green-500 group-hover:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          Entrar
        </button>
      </div>
    </form>

  </div>
</body>

</html>