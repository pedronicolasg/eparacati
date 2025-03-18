<div id="equipmentAddModal" tabindex="-1" aria-hidden="true"
  class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-300 ease-in-out opacity-0">
  <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-800">
    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
        Cadastrar novo Equipamento
      </h3>
      <button onclick="closeequipmentAddModal()" id="equipmentadd-close-modal-btn" type="button"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" aria-hidden="true">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1l6 6m0 0l6-6M7 7l6 6m-6-6L1 13" />
        </svg>
        <span class="sr-only">Fechar</span>
      </button>
    </div>

    <form action="../../src/handlers/equipment/register.php" method="POST" enctype="multipart/form-data" class="p-4 md:p-5">

      <div class="grid gap-4 mb-4 grid-cols-2">
        <div class="col-span-2">
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome*</label>
          <input type="text" name="name" id="name"
            class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white"
            placeholder="Ex: Notebook #17" required>
        </div>

        <div class="col-span-2 sm:col-span-1">
          <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo*</label>
          <select id="type" name="type" type="type"
            class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
            <option selected>Selecione</option>
            <option value="notebook">Notebook</option>
            <option value="extensao">Extensão</option>
            <option value="projetor">Projetor</option>
            <option value="sala">Sala</option>
            <option value="outro">Outro</option>
          </select>
        </div>

        <div class="col-span-2 sm:col-span-1">
          <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status*</label>
          <select id="status" name="status" type="status"
            class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
            <option value="disponivel" selected>Disponível</option>
            <option value="indisponivel">Indisponível</option>
          </select>
        </div>

        <div class="col-span-2">
          <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Imagem:</label>
          <input type="file" name="image" id="image" accept="image/*" required class="block w-full text-sm text-gray-500
                file:me-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-700 file:text-white
                hover:file:bg-blue-800
                file:disabled:opacity-50 file:disabled:pointer-events-none
                dark:text-neutral-500
                dark:file:bg-blue-700
                dark:hover:file:bg-blue-800
              ">
        </div>

        <div class="col-span-2">
          <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
          <textarea id="description" name="description" class="shadow-lg w-full px-3 py-2 rounded-md border focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100" style="height: 180px;"></textarea>
        </div>

      </div>
      <button type="submit"
        class="w-full text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-4 py-2.5 text-sm font-medium text-center">
        <i class="fas fa-plus mr-2"></i> Cadastrar
      </button>
    </form>
  </div>
</div>