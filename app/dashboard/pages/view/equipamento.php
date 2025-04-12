<div class="container mx-auto px-4 py-8">
  <form action="../../src/handlers/equipment/edit.php"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white dark:bg-gray-800 shadow-xl rounded-xl px-4 sm:px-8 pt-6 pb-8 mb-4 transition-all duration-300 hover:shadow-2xl">
    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Equipamento</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Atualize as informações do equipamento conforme necessário.</p>
    </div>
    <input type="hidden" name="id" name="id" value="<?php echo $currentEquipment["id"]; ?>">
    <div class="flex flex-col lg:flex-row lg:space-x-8">
      <div class="mb-6 lg:w-1/2">
        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="imagem">
          Imagem do Equipamento
        </label>
        <div class="flex flex-col items-center space-y-4">
          <div class="relative w-full aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
            <img id="output"
              src="<?php echo !empty($currentEquipment['image']) ? $currentEquipment['image'] : 'https://placehold.co/900x600.png'; ?>"
              alt="Imagem atual do equipamento"
              class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
          </div>
          <div class="flex w-full space-x-3">
            <div class="relative flex-grow">
              <input onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                type="file" id="image" name="image" accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
              <label for="image"
                class="flex items-center justify-center w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 cursor-pointer group">
                <i class="fas fa-upload mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                Escolher Imagem
              </label>
            </div>
            <button type="button"
              onclick="deleteEquipmentImage('<?php echo Security::hide($currentEquipment['id']); ?>')"
              class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium p-2.5 rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group"
              aria-label="Deletar imagem">
              <i class="fas fa-trash-alt group-hover:scale-110 transition-transform duration-300"></i>
            </button>
            <script src="../../../public/assets/js/dashboard/equipment/ajax.js"></script>
          </div>
        </div>
      </div>

      <div class="lg:w-1/2 space-y-6">
        <div>
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="name">
            Nome do Equipamento
          </label>
          <input value="<?php echo $currentEquipment['name']; ?>"
            class="w-full px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300"
            id="name" name="name" type="text" placeholder="Digite o nome do equipamento">
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="type">
            Tipo de Equipamento
          </label>
          <div class="relative">
            <select
              class="w-full px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300"
              id="type" name="type">
              <option value="">Selecione o tipo</option>
              <?php
              $options = $equipmentController->getTypes();

              foreach ($options as $option) {
                $selected = $currentEquipment['type'] == $option ? 'selected' : '';
                echo "<option value=\"$option\" $selected>" . Format::typeName($option) . "</option>";
              }
              ?>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <i class="fas fa-chevron-down text-gray-400"></i>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="status">
            Status do Equipamento
          </label>
          <div class="relative">
            <select
              class="w-full px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300"
              id="status" name="status">
              <option value="">Selecione o status</option>
              <?php
              $statusOptions = [
                'disponivel' => 'Disponível',
                'indisponivel' => 'Indisponível'
              ];

              foreach ($statusOptions as $value => $label) {
                $selected = $currentEquipment['status'] == $value ? 'selected' : '';
                echo "<option value=\"$value\" $selected>$label</option>";
              }
              ?>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <i class="fas fa-chevron-down text-gray-400"></i>
            </div>
          </div>
        </div>

        <div>
          <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="description">
            Descrição do Equipamento
          </label>
          <textarea
            class="w-full px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300 resize-none"
            name="description" id="description" rows="8"
            placeholder="Descreva as características do equipamento"><?php echo $currentEquipment['description']; ?></textarea>
        </div>
      </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
      <div class="flex space-x-3">
        <button
          class="inline-flex items-center px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group"
          type="submit">
          <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-300"></i>
          Salvar Alterações
        </button>
        <button
          onclick="if(confirm('Tem certeza que deseja deletar o equipamento?')) { window.location.href='../../src/handlers/equipment/delete.php?id=<?php echo $currentEquipment['id']; ?>'; }"
          class="inline-flex items-center px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group"
          type="button" aria-label="Deletar Equipamento">
          <i class="fas fa-trash-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
          Deletar
        </button>
      </div>
      <a href="./equipamentos.php"
        class="inline-flex items-center px-4 py-2.5 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group">
        <i class="fas fa-times mr-2 group-hover:scale-110 transition-transform duration-300"></i>
        Cancelar
      </a>
    </div>
  </form>
</div>