<?php
require_once '../methods/usermanager.php';
require_once '../methods/UI.php';

$userManager = new UserManager($conn);
$theme = $userManager->getTheme($_SESSION['id']);
UserManager::verifySession("../auth/login.php", ["gestao", "professor"]);
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../assets/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php UI::renderNavbar('../', 'Dashboard', 'blue', 'altlogo.svg') ?>
  <div class="min-h-full">

    <header class="bg-white shadow dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-200">Dashboard (<?php echo $_SESSION['role'] ?>)</h1>
      </div>
    </header>

    <main>
      <?php include 'includes/' . $_SESSION['role'] . '.ui.php' ?>
    </main>

  </div>
  <?php UI::renderFooter('../',); ?>
</body>

</html>