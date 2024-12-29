<?php
require_once 'methods/UI.php';
require_once 'methods/usermanager.php';
UserManager::verifySession("./login.php");
$userManager = new UserManager($conn);
$theme = $userManager->getTheme($_SESSION['id']);

?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets/images/logo.svg" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php
  UI::renderNavbar('./', 'Home', 'green');

  $carouselItems = [
    ["image" => "assets/images/carousel1.png", "title" => "Slide 1"],
    ["image" => "assets/images/carousel2.png", "title" => "Slide 2"],
  ];

  UI::renderCarousel('./', $carouselItems);
  ?>

  <main class="flex flex-col items-center min-h-screen">
    <h1 class="text-4xl font-bold">Olá, <?php echo $_SESSION['name'] ?>!</h1>
  </main>

  <?php
  UI::renderApps($_SESSION['role']);
  UI::renderFooter('./');
  ?>
</body>

</html>