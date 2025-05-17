<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-5xl mx-auto">
    <form action="../../src/controllers/equipment/edit.php"
      method="POST"
      enctype="multipart/form-data"
      class="relative overflow-hidden bg-white dark:bg-gray-800 shadow-2xl rounded-2xl transition-all duration-300 transform hover:-translate-y-1">
      
      <div class="relative bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-4 overflow-hidden rounded-t-2xl">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
        
        <div class="relative z-10 flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <div class="bg-white/20 p-2 rounded-lg shadow-inner">
              <i class="fas fa-tools text-white text-lg"></i>
            </div>
            
            <div>
              <h2 class="text-2xl font-bold text-white tracking-tight">
                Editar Equipamento
              </h2>
              <p class="text-blue-100 text-sm font-medium">
                Atualize as informações do equipamento conforme necessário
              </p>
            </div>
          </div>
          
          <a href="equipamentos.php" class="bg-white/10 hover:bg-white/20 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Voltar</span>
          </a>
        </div>
      </div>

      <div class="p-6 sm:p-10">
        <input type="hidden" name="id" value="<?php echo $currentEquipment["id"]; ?>">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-8">
          <div class="space-y-6">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 p-1 rounded-xl shadow-inner">
              <div class="relative group overflow-hidden rounded-lg bg-white dark:bg-gray-900 aspect-w-16 aspect-h-9 shadow-md">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                  <p class="text-white text-sm font-medium">Clique para alterar a imagem</p>
                </div>
                
                <img id="output"
                  src="<?php echo !empty($currentEquipment['image']) ? $currentEquipment['image'] : 'https://placehold.co/900x600.png'; ?>"
                  alt="Imagem atual do equipamento"
                  class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105">
              </div>
            </div>
            
            <div class="flex items-center space-x-4">
              <div class="relative flex-grow">
                <input onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])"
                  type="file" id="image" name="image" accept=".png, .jpeg, .jpg, .webp"
                  class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <label for="image"
                  class="flex items-center justify-center w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 cursor-pointer group shadow-lg shadow-blue-500/20">
                  <i class="fas fa-cloud-upload-alt mr-2 text-lg group-hover:scale-110 transition-transform duration-300"></i>
                  Escolher Nova Imagem
                </label>
              </div>
              <button type="button"
                onclick="deleteEquipmentImage('<?php echo Security::hide($currentEquipment['id']); ?>')"
                class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium p-3 rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group shadow-lg shadow-red-500/20 flex items-center justify-center">
                <i class="fas fa-trash-alt group-hover:scale-110 transition-transform duration-300"></i>
              </button>
            </div>
            
            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 border-l-4 border-blue-500 dark:border-blue-400">
              <div class="flex">
                <div class="flex-shrink-0">
                  <i class="fas fa-info-circle text-blue-500 dark:text-blue-400 text-lg"></i>
                </div>
                <div class="ml-3">
                  <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Sobre as imagens</h3>
                  <div class="mt-2 text-sm text-blue-700 dark:text-blue-200">
                    <p>É recomendado imagens com resolução 900x600 e tamanho máximo de 2MB para melhor visualização.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <div class="space-y-2">
              <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="name">
                <i class="fas fa-tag mr-2 text-blue-500 dark:text-blue-400"></i>
                Nome do Equipamento
              </label>
              <div class="relative">
                <input value="<?php echo $currentEquipment['name']; ?>"
                  class="w-full pl-4 pr-10 py-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300 shadow-sm"
                  id="name" name="name" type="text" placeholder="Digite o nome do equipamento">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <i class="fas fa-keyboard text-gray-400"></i>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="type">
                <i class="fas fa-sitemap mr-2 text-blue-500 dark:text-blue-400"></i>
                Tipo de Equipamento
              </label>
              <div class="relative">
                <select
                  class="w-full pl-4 pr-10 py-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300 shadow-sm"
                  id="type" name="type">
                  <option value="">Selecione o tipo</option>
                  <?php
                  $options = $equipmentModel->getTypes();

                  foreach ($options as $option) {
                    $selected = $currentEquipment['type'] == $option ? 'selected' : '';
                    echo "<option value=\"$option\" $selected>" . Format::typeName($option) . "</option>";
                  }
                  ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                  <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="status">
                <i class="fas fa-toggle-on mr-2 text-blue-500 dark:text-blue-400"></i>
                Status do Equipamento
              </label>
              <div class="relative">
                <select
                  class="w-full pl-4 pr-10 py-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300 shadow-sm"
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
                <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                  <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
              </div>
            </div>

            <div class="space-y-2">
              <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold" for="description">
                <i class="fas fa-align-left mr-2 text-blue-500 dark:text-blue-400"></i>
                Descrição do Equipamento
              </label>
              <div class="relative">
                <textarea
                  class="w-full pl-4 pr-10 py-3 text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-colors duration-300 resize-none shadow-sm"
                  name="description" id="description" rows="6"
                  placeholder="Descreva as características do equipamento"><?php echo $currentEquipment['description']; ?></textarea>
                <div class="absolute top-3 right-0 flex items-start px-3 pointer-events-none">
                  <i class="fas fa-pen text-gray-400"></i>
                </div>
              </div>
              <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Forneça detalhes relevantes sobre o equipamento, como modelo, especificações e condições de uso.</p>
            </div>
          </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <button
              class="relative overflow-hidden group w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-medium rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg shadow-green-500/20"
              type="submit">
              <span class="absolute inset-0 w-full h-full bg-white/10 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500"></span>
              <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-300"></i>
              Salvar Alterações
            </button>
            <button
              onclick="if(confirm('Tem certeza que deseja deletar o equipamento?')) { window.location.href='../../src/controllers/equipment/delete.php?id=<?php echo $currentEquipment['id']; ?>'; }"
              class="relative overflow-hidden group w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-medium rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-lg shadow-red-500/20"
              type="button" aria-label="Deletar Equipamento">
              <span class="absolute inset-0 w-full h-full bg-white/10 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500"></span>
              <i class="fas fa-trash-alt mr-2 group-hover:scale-110 transition-transform duration-300"></i>
              Deletar Equipamento
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>