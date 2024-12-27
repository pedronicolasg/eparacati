<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets/images/logo.svg" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/carousel.php'; ?>

  <main class="flex flex-col items-center min-h-screen">
    <h1 class="text-4xl font-bold">Olá, <?php //$_SESSION['name']
                                        ?>Nícolas!</h1>
  </main>

  <?php include 'includes/apps.php'; ?>
  <?php include 'includes/footer.php'; ?>
</body>

</html>