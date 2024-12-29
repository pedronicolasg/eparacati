<?php
require_once '../../methods/verify.php';
require_once '../../methods/conn.php';
require_once '../../methods/crypt.php';

verification("../auth/login.php", ["gestao", "professor"]);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EP Aracati | Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../assets/images/altlogo.svg" type="image/x-icon">
</head>

<body>
  <div class="min-h-full">
    <?php include './includes/navbar.php'; ?>

    <header class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Dashboard (<?php echo $_SESSION['role'] ?>)</h1>
      </div>
    </header>

    <main>
      <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
        <?php
        $sql = "SELECT id, name, email, role, profile_photo FROM users";
        $result = $conn->prepare($sql);
        $result->execute();


        if ($result->rowCount() > 0) {
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<li class="pb-3 sm:pb-4"> 
                    <div class="flex items-center space-x-4 rtl:space-x-reverse"> 
                      <div class="flex-shrink-0"> 
                        <img class="w-8 h-8 rounded-full" src="' . htmlspecialchars($row['profile_photo']) . '" alt="User image"> 
                      </div> 
                      <div class="flex-1 min-w-0"> 
                        <a class="text-sm font-medium text-gray-900 truncate dark:text-white" href="../../perfil.php?id=' . htmlspecialchars(Crypt::HIDE($row['id'])) . '"> ' . htmlspecialchars($row['name']) . ' </a> 
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400"> ' . htmlspecialchars($row['email']) . ' </p> 
                      </div> 
                      <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"> ' . htmlspecialchars($row['role']) . ' </div> 
                    </div> 
                  </li>';
          }
        } else {
          echo '<li class="text-center">Nenhum usuário encontrado.</li>';
        }
        ?>
      </ul>
    </main>
  </div>
</body>

</html>