<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="shortcut icon" href="../assets/images/logo.svg" type="image/x-icon">
  <style>
    .glassmorphism {
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.18);
    }
  </style>
</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://sinalnews.com.br/wp-content/uploads/2021/12/WhatsApp-Image-2021-12-08-at-22.22.04.jpeg');">
  <div class="glassmorphism p-8 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-6 text-center text-white">Login</h2>
    <form action="../methods/login.php" method="POST">
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-white mb-2">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-white placeholder-opacity-70">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-white mb-2">Senha</label>
        <input type="password" id="password" name="password" required
          class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-white placeholder-white placeholder-opacity-70">
      </div>
      <button type="submit"
        class="w-full bg-blue-500 bg-opacity-80 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300">
        Log In
      </button>
    </form>
  </div>
</body>

</html>