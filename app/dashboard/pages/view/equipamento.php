<div class="container mx-auto px-4 py-8">
  <form action="../../src/handlers/equipment/edit.php"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white dark:bg-gray-800 shadow-md rounded px-4 sm:px-8 pt-6 pb-8 mb-4">
    <input type="hidden" name="id" name="id" value="<?php echo $currentEquipment["id"]; ?>">
    <div class="flex flex-col md:flex-row md:space-x-8">
      <div class="mb-6 md:w-1/2">
        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="imagem">
          Imagem do Equipamento
        </label>
        <div class="flex flex-col items-center space-y-4">
          <img id="output"
            src="<?php echo !empty($currentEquipment['image']) ? $currentEquipment['image'] : 'https://placehold.co/900x600.png'; ?>"
            alt="Imagem atual do equipamento" class="w-full h-auto object-cover rounded">
          <div class="flex w-full space-x-2">
            <div class="relative flex-grow">
              <input onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                type="file" id="image" name="image" accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
              <label for="image"
                class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">
                <i class="fas fa-upload mr-2"></i>
                Escolher Imagem
              </label>
            </div>
            <button type="button"
              onclick="if(confirm('Tem certeza que deseja deletar a imagem?')) { window.location.href='../../methods/handlers/equipment/deleteImage.php?id=<?php echo Security::hide($currentEquipment['id']); ?>'; }"
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline"
              aria-label="Deletar imagem">
              <i class="fas fa-trash-alt"></i>
            </button>
          </div>
        </div>
      </div>

      <div class="md:w-1/2">
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="name">
            Nome
          </label>
          <input value="<?php echo $currentEquipment['name']; ?>"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"
            id="name" name="name" type="text" placeholder="Nome do equipamento">
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="type">
            Tipo
          </label>
          <select
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"
            id="type" name="type">
            <option value="">Selecione o tipo</option>
            <?php
            $options = [
              'notebook' => 'Notebook',
              'extensao' => 'Extensão',
              'projetor' => 'Projetor',
              'sala' => 'Sala',
              'outro' => 'Outro'
            ];

            foreach ($options as $value => $label) {
              $selected = $currentEquipment['type'] == $value ? 'selected' : '';
              echo "<option value=\"$value\" $selected>$label</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="status">
            Status
          </label>
          <select
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"
            id="status" name="status">
            <option value="">Selecione o status</option>
            <?php
            $statusOptions = [
              'disponivel' => 'Disponível',
              'agendado' => 'Agendado',
              'indisponivel' => 'Indisponível'
            ];

            foreach ($statusOptions as $value => $label) {
              $selected = $currentEquipment['status'] == $value ? 'selected' : '';
              echo "<option value=\"$value\" $selected>$label</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-6">
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="description">
            Descrição
          </label>
          <textarea style="height: 223px;"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"
            name="description" id="description" rows="4"
            placeholder="Descreva o equipamento"><?php echo $currentEquipment['description']; ?></textarea>
        </div>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4">
      <div class="flex space-x-2">
        <button
          class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          type="submit">
          Salvar Alterações
        </button>
        <button
          onclick="if(confirm('Tem certeza que deseja deletar o equipamento?')) { window.location.href='../../src/handlers/equipment/delete.php?id=<?php echo $currentEquipment['id']; ?>'; }"
          class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded focus:outline-none focus:shadow-outline"
          type="button" aria-label="Deletar">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
      <a href="./equipamentos.php"
        class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
        Cancelar
      </a>
    </div>
  </form>
</div>