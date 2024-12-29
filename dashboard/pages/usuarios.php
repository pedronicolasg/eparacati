<?php
require_once '../../methods/usermanager.php';
require_once '../../methods/conn.php';
require_once '../../methods/crypt.php';
require_once '../../methods/UI.php';
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
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../../assets/images/altlogo.svg" type="image/x-icon">
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <div class="min-h-full">
    <?php UI::renderNavbar('../../', 'Dashboard', 'blue', 'altlogo.svg'); ?>

    <header class="bg-white shadow-lg dark:bg-gray-900">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-200">Dashboard (<?php echo $_SESSION['role'] ?>)</h1>

        <!-- Breadcrumb -->
        <nav class="flex" style="margin-top: 15px;" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
              <a href="../index.php" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                <i class="fas fa-pager w-3 h-3 me-2.5"></i>
                Dashboard
              </a>
            </li>
            <li aria-current="page">
              <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Usuários</span>
              </div>
            </li>
          </ol>
        </nav>
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
                        <img class="w-8 h-8 rounded-full" src="' . htmlspecialchars($row['profile_photo']) . '" alt="Foto do usuário"> 
                      </div> 
                      <div class="flex-1 min-w-0"> 
                        <a class="text-sm font-medium text-gray-900 truncate dark:text-white" href="../../perfil.php?id=' . htmlspecialchars(Crypt::hide($row['id'])) . '"> ' . htmlspecialchars($row['name']) . ' </a> 
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