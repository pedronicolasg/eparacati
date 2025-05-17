<?php
require_once __DIR__ . "/src/bootstrap.php";
?>
<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo htmlspecialchars($theme); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EP Aracati</title>
    <link rel="stylesheet" href="../public/css/output.css">
    <link rel="shortcut icon" href="../public/images/logo.svg" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <?php
    UI::renderNavbar($currentUser, "./", "Home", "green");
    UI::renderPopup(true);
    ?>

    <main class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md">
            <i class="fas fa-tools text-4xl text-green-500 dark:text-green-400 mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-2">Página em Desenvolvimento</h1>
            <?php
            $role = isset($currentUser['role']) ? strtolower($currentUser['role']) : 'default';

            if ($role === 'aluno') {
            ?>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Olá, Aluno! Nosso site está em construção, mas logo traremos novidades incríveis para você. Pedimos um pouco de paciência enquanto finalizamos tudo!
                </p>
            <?php
            } else {
            ?>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Olá, <?= Format::roleName($currentUser['role'], true)?>! O site está em fase de construção, mas a Dashboard já permite gerenciar o sistema. Acesse para explorar as funcionalidades atuais!
                </p>
                <a href="dashboard/" class="mt-4 inline-block px-4 py-2 bg-green-500 dark:bg-green-400 text-white dark:text-gray-900 rounded-md hover:bg-green-600 dark:hover:bg-green-300">
                    Ir para a Dashboard
                </a>
            <?php
            }
            ?>
        </div>
    </main>

    <?php
    UI::renderFooter("./");
    ?>
</body>

</html>