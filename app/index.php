<?php
$basepath = "src/";
require_once __DIR__ . "/src/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EP Aracati</title>
    <link rel="stylesheet" href="../public/assets/css/output.css">
    <link rel="shortcut icon" href="../public/assets/images/logo.svg" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <?php
    UI::renderNavbar($currentUser, "./", "Home", "green");
    UI::renderPopup(true);

    $carouselItems = [
        ["image" => "../public/assets/images/carousel1.png", "text" => "O grande momento chegou! O edital de matrícula para os novatos 2025 já está disponível!"],
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
    ?>

    <main class="flex flex-col items-center min-h-screen">
        <?php UI::renderHeader("./", $carouselItems, $newsItems); ?>
    </main>

    <?php
    UI::renderApps($currentUser["role"]);
    UI::renderFooter("./");
    ?>
</body>

</html>