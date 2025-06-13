<main class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl mb-8">
      <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
          <i class="fas fa-edit h-6 w-6 mr-2 text-blue-600 dark:text-blue-400"></i>
          Painel de Edição
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atualize as informações da turma conforme necessário</p>
      </div>

      <div class="p-6">
        <form class="space-y-6" action="../../src/controllers/class/edit.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $viewClass["id"]; ?>">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Nome da Turma
              </label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-home text-lg text-gray-400 dark:text-gray-500"></i>
                </div>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($viewClass["name"]); ?>"
                  class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 py-3 text-base" />
              </div>
            </div>

            <div class="space-y-2">
              <label for="grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Ano Escolar
              </label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-graduation-cap text-lg text-gray-400 dark:text-gray-500"></i>
                </div>
                <select id="grade" name="grade"
                  class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 py-3 text-base">
                  <option value="1" <?php echo $viewClass["grade"] == 1 ? "selected" : ""; ?>>1º Ano</option>
                  <option value="2" <?php echo $viewClass["grade"] == 2 ? "selected" : ""; ?>>2º Ano</option>
                  <option value="3" <?php echo $viewClass["grade"] == 3 ? "selected" : ""; ?>>3º Ano</option>
                </select>
              </div>
            </div>

            <div class="space-y-2">
              <label for="pdt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Professor Diretor de Turma
              </label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user text-lg text-gray-400 dark:text-gray-500"></i>
                </div>
                <select id="pdt" name="pdt"
                  class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 py-3 text-base">
                  <?php
                  if (isset($currentPDT['id'])) {
                    echo '<option value="">Nenhum</option>';
                    echo '<option value="' . htmlspecialchars($currentPDT["id"]) . '" selected>' . htmlspecialchars($currentPDT["name"]) . '</option>';
                  } else {
                    echo '<option value="" selected>Nenhum</option>';
                  }
                  $professors = $userModel->getByRole("professor");
                  foreach ($professors as $professor) {
                    if (!isset($currentPDT['id']) || $professor["id"] != $currentPDT["id"]) {
                      echo '<option value="' . htmlspecialchars($professor["id"]) . '">' . htmlspecialchars($professor["name"]) . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="space-y-2">
              <label for="leader" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Líder de Turma
              </label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user text-lg text-gray-400 dark:text-gray-500"></i>
                </div>
                <select id="leader" name="leader"
                  class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 py-3 text-base">
                  <?php
                  echo '<option value="">Nenhum</option>';
                  if (isset($currentLeader['id'])) {
                    echo '<option value="' . htmlspecialchars($currentLeader["id"]) . '" selected>' . htmlspecialchars($currentLeader["name"]) . '</option>';
                  }
                  foreach ($students as $student) {
                    if (!isset($currentLeader['id']) || $student["id"] != $currentLeader["id"]) {
                      echo '<option value="' . htmlspecialchars($student["id"]) . '">' . htmlspecialchars($student["name"]) . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="space-y-2 md:col-span-2">
              <label for="vice_leader" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Vice-líder de Turma
              </label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user text-lg text-gray-400 dark:text-gray-500"></i>
                </div>
                <select id="vice_leader" name="vice_leader"
                  class="pl-10 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 py-3 text-base">
                  <?php
                  echo '<option value="">Nenhum</option>';
                  if (isset($currentViceLeader['id'])) {
                    echo '<option value="' . htmlspecialchars($currentViceLeader["id"]) . '" selected>' . htmlspecialchars($currentViceLeader["name"]) . '</option>';
                  }
                  foreach ($students as $student) {
                    if (!isset($currentViceLeader['id']) || $student["id"] != $currentViceLeader["id"]) {
                      echo '<option value="' . htmlspecialchars($student["id"]) . '">' . htmlspecialchars($student["name"]) . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="pt-5 border-t border-gray-200 dark:border-gray-700">
            <div class="flex flex-col sm:flex-row gap-3">
              <button type="submit"
                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-check -ml-1 mr-2 text-lg"></i>
                Salvar Alterações
              </button>
              <button type="button" onclick="confirmDeleteClass(<?php echo htmlspecialchars($viewClass['id']); ?>)"
                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-trash -ml-1 mr-2 text-lg"></i>
                Deletar Turma
              </button>
              <button type="button" onclick="confirmDeleteClassAndUsers(<?php echo htmlspecialchars($viewClass['id']); ?>)"
                class="flex-1 inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-user-minus -ml-1 mr-2 text-lg"></i>
                Deletar Turma e Alunos
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
      <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-700">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
          <i class="fas fa-users h-6 w-6 mr-2 text-indigo-600 dark:text-indigo-400"></i>
          Alunos da Turma
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lista de todos os alunos matriculados nesta turma</p>
      </div>

      <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-blue-400 dark:scrollbar-thumb-blue-700 scrollbar-track-blue-100 dark:scrollbar-track-blue-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuário</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cargo</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Turma</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT u.id, u.name, u.email, u.role, u.profile_photo, u.class_id, c.name as class_name
            FROM users u
            LEFT JOIN classes c ON u.class_id = c.id
            WHERE u.class_id = :class_id
            ORDER BY CASE u.role
                  WHEN 'lider' THEN 1
                  WHEN 'vice_lider' THEN 2
                  WHEN 'aluno' THEN 3
                  ELSE 4
                 END";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":class_id", $viewClassId, PDO::PARAM_INT);

            $stmt->execute();

            $roleColors = [
              'aluno' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
              'lider' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
              'vice_lider' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-200',
              'gremio' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            ];

            if ($stmt->rowCount() > 0) {
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($row["role"] == "pdt"): continue;
                endif;
                $roleClass = isset($roleColors[$row["role"]]) ? $roleColors[$row["role"]] : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
            ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-4">
                      <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden ring-2 ring-indigo-500 ring-offset-2 dark:ring-offset-gray-800">
                        <img class="h-full w-full object-cover" src="<?= htmlspecialchars($row["profile_photo"]) ?>" alt="Foto do usuário">
                      </div>
                      <div>
                        <div class="text-base font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200">
                          <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>" class="hover:underline">
                            <?= htmlspecialchars($row["name"]) ?>
                          </a>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                          <?= htmlspecialchars($row["email"]) ?>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    <?= htmlspecialchars($row["id"]) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $roleClass ?>">
                      <?= htmlspecialchars(Format::roleName($row["role"])) ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    <?= htmlspecialchars($row["class_name"]) ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>&editPanel" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium hover:underline transition-colors duration-200 flex items-center gap-1">
                      <i class="fas fa-pencil-alt h-4 w-4"></i>
                      Editar
                    </a>
                  </td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr>
                <td colspan="5" class="px-6 py-4 text-center">Nenhum usuário encontrado nessa turma.</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>