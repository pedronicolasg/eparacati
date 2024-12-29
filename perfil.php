<?php
require_once 'methods/verify.php';
require_once 'methods/conn.php';
require_once 'methods/crypt.php';
verification("./auth/login.php");
$id = isset($_GET['id']) ? Crypt::SHOW($_GET['id']) : null;
$userId = isset($id) ? intval($id) : $_SESSION['id'];
$isCurrentUser = $userId === $_SESSION['id'];

try {
  $stmt = $conn->prepare("SELECT id, name, email, role, class_id, profile_photo FROM users WHERE id = :id");
  $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    die("Usuário não encontrado.");
  }
} catch (PDOException $e) {
  die("Erro ao buscar dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Perfil de </title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php include 'includes/navbar.php'; ?>

  <!-- Seção de Perfil -->
  <div class="container mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!-- Informações do Usuário -->
      <div class="p-4 rounded-lg shadow-md bg-white dark:bg-gray-800">
        <div class="flex items-center">
          <img src="<?php echo htmlspecialchars($user['profile_photo'] ?: 'https://placehold.co/100'); ?>"
            alt="Foto do usuário" class="rounded-full w-24 h-24" />
          <div class="ml-4">
            <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($user['name']); ?></h2>
            <p class="text-gray-500 dark:text-gray-400">
              <?php
              echo htmlspecialchars($user['role']);
              if (!empty($user['class_id'])) {
                echo " | Turma: " . htmlspecialchars($user['class_id']);
              }
              ?>
            </p>
          </div>
        </div>
        <div class="mt-4">
          <p>Email:</p>
          <p class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($user['email']); ?></p>
        </div>
      </div>

      <!-- Seção de Posts -->
      <div class="p-4 rounded-lg md:col-span-2 shadow-md bg-white dark:bg-gray-800">
        <h2 class="text-xl font-bold">Posts do usuário</h2>
        <div class="mt-4 text-center">
          <p class="text-gray-500 dark:text-gray-400">*EM BREVE*</p>
        </div>
      </div>

      <!-- Painel de Edição (Apenas para o próprio usuário) -->
      <?php if ($isCurrentUser): ?>
        <div class="md:col-span-3 p-4 rounded-lg shadow-md bg-white dark:bg-gray-800">
          <h2 class="text-xl font-bold">Painel de Edição</h2>
          <form class="mt-4" action="update_profile.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
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
            </div>
            <div class="mt-4">
              <label for="profilePhoto" class="block text-gray-700 dark:text-gray-300">Foto de Perfil</label>
              <input type="file" id="profilePhoto" name="profile_photo"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>
            <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
              Salvar Alterações
            </button>
          </form>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>
</body>

</html>