<?php
require_once 'methods/bootstrap.php';

$id = isset($_GET['id']) ? Utils::show($_GET['id']) : null;
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
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Perfil de <?php echo htmlspecialchars($user['name']); ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="assets/images/logo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php UI::renderNavbar($currentUser, './',) ?>

  <div class="container mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-4 rounded-lg shadow-md bg-white dark:bg-gray-800">
        <div class="flex items-center">
          <img src="<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Foto do usuário"
            class="rounded-full w-24 h-24" />
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

      <div class="p-4 rounded-lg md:col-span-2 shadow-md bg-white dark:bg-gray-800">
        <h2 class="text-xl font-bold">Posts do usuário</h2>
        <div class="mt-4 text-center">
          <p class="text-gray-500 dark:text-gray-400">*EM BREVE*</p>
        </div>
      </div>

      <?php if ($currentUser['role'] === 'gestao') {
        UI::renderUserEditionPanel($user);
      } ?>
    </div>
  </div>

  <?php UI::renderFooter('./'); ?>
</body>

</html>