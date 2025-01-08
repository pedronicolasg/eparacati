<?php
require_once "methods/bootstrap.php"; ?>
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
  UI::renderNavbar($currentUser, "./", "Home", "green");

  $carouselItems = [
      [
          "image" => "https://placehold.co/800x400.png",
          "text" => "Slide 1",
      ],
      ["image" => "https://placehold.co/800x400.png", "text" => "Slide 2"],
      ["image" => "https://placehold.co/800x400.png", "text" => "Slide 3"],
  ];

  $newsItems = [
      [
          "category" => "CATEGORIA DO ITEM",
          "title" =>
              "CONTEÚDO DO ITEM, EX: Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
      ],
      [
          "category" => "CATEGORIA DO ITEM",
          "title" =>
              "CONTEÚDO DO ITEM, EX: Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
      ],
  ];

  UI::renderHeader("./", $carouselItems, $newsItems);
  ?>

  <main class="flex flex-col items-center min-h-screen">

  </main>

  <?php
  UI::renderApps($currentUser["role"]);
  UI::renderFooter("./");
  ?>
</body>

</html>
