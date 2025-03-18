<main>
  <div class="max-w-7xl mx-auto px-4 mt-5">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
      <div class="md:col-span-3 p-4 rounded-lg shadow-md bg-white dark:bg-gray-800">
        <h2 class="text-xl font-bold">Painel de Edição</h2>
        <form class="mt-4" action="../../src/handlers/class/edit.php" method="POST"
          enctype="multipart/form-data">
          <input type="hidden" name="id" name="id" value="<?php echo $viewClass["id"]; ?>">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="name" class="block text-gray-700 dark:text-gray-300">Nome</label>
              <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($viewClass["name"]); ?>"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" />
            </div>

            <div>
              <label for="grade" class="block text-gray-700 dark:text-gray-300">Ano</label>
              <select id="grade" name="grade"
                class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                <option value="1" <?php echo $viewClass["grade"] == 1 ? "selected" : ""; ?>>1º Ano</option>
                <option value="2" <?php echo $viewClass["grade"] == 2 ? "selected" : ""; ?>>2º Ano</option>
                <option value="3" <?php echo $viewClass["grade"] == 3 ? "selected" : ""; ?>>3º Ano</option>
              </select>
            </div>

            <div>
              <label for="pdt" class="block text-gray-700 dark:text-gray-300">Professor diretor de turma</label>
              <select id="pdt" name="pdt"
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
              <?php
              if (isset($currentPDT['id'])) {
                echo '<option value="">Nenhum</option>';
                echo '<option value="' . htmlspecialchars($currentPDT["id"]) . '" selected>' . htmlspecialchars($currentPDT["name"]) . '</option>';
              } else {
                echo '<option value="" selected>Nenhum</option>';
              }
              $professors = $userController->getByRole("professor");
              foreach ($professors as $professor) {
                if (!isset($currentPDT['id']) || $professor["id"] != $currentPDT["id"]) {
                echo '<option value="' . htmlspecialchars($professor["id"]) . '">' . htmlspecialchars($professor["name"]) . '</option>';
                }
              }
              ?>
              </select>
            </div>

            <div>
              <label for="leader_id" class="block text-gray-700 dark:text-gray-300">Líder</label>
              <select id="leader" name="leader"
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
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

            <div>
              <label for="vice_leader_id" class="block text-gray-700 dark:text-gray-300">Vice-líder</label>
              <select id="vice_leader" name="vice_leader"
              class="w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
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
          <button type="submit"
            class="mt-4 bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition">
            Salvar Alterações
          </button>
            <button type="button" onclick="confirmDeleteClass(<?php echo htmlspecialchars($viewClass['id']); ?>)"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
            Deletar Turma
            </button>
            <button type="button" onclick="confirmDeleteClassAndUsers(<?php echo htmlspecialchars($viewClass['id']); ?>)"
            class="mt-4 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
            Deletar Turma e Alunos
            </button>
        </form>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 mt-5 mb-5">
    <table class="w-full text-sm text-left">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="px-6 py-3">Usuário</th>
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3">Cargo</th>
          <th class="px-6 py-3">Turma</th>
          <th class="px-6 py-3">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT u.id, u.name, u.email, u.role, u.profile_photo, u.class_id, c.name as class_name
                  FROM users u
                  LEFT JOIN classes c ON u.class_id = c.id
                  WHERE u.class_id = :class_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":class_id", $viewClassId, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                  <img class="w-10 h-10 rounded-full" src="<?= htmlspecialchars($row["profile_photo"]) ?>"
                    alt="Foto do usuário">
                  <div>
                    <div class="font-medium text-gray-900 dark:text-white">
                      <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>">
                        <?= htmlspecialchars($row["name"]) ?>
                      </a>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                      <?= htmlspecialchars($row["email"]) ?>
                    </div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                <?= htmlspecialchars($row["id"]) ?>
              </td>
              <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                <?= htmlspecialchars(Format::roleName($row["role"])) ?>
              </td>
              <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                <?= htmlspecialchars($row["class_name"]) ?>
              </td>
              <td class="px-6 py-4">
                <a href="../../perfil.php?id=<?= htmlspecialchars(Security::hide($row["id"])) ?>&editPanel"
                  class="text-blue-600 hover:underline dark:text-blue-500">
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
</main>