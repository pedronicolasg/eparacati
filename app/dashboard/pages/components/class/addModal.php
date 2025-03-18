<div id="classAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-300 ease-in-out opacity-0">
    <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Cadastrar nova Turma
            </h3>
            <button onclick="closeclassAddModal()" id="classadd-close-modal-btn" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" aria-hidden="true">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1l6 6m0 0l6-6M7 7l6 6m-6-6L1 13" />
                </svg>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form action="../../src/handlers/class/create.php" method="POST" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2 sm:col-span-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Curso/Nome*</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white"
                        placeholder="Ex: Informática C" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="grade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ano*</label>
                    <select id="grade" name="grade" type="grade"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
                        <option selected>Selecione</option>
                        <option value="1">1º Ano</option>
                        <option value="2">2º Ano</option>
                        <option value="3">3º Ano</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="pdt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID ou Email do PDT</label>
                    <input type="text" name="pdt" id="pdt"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
                </div>

                <div class="col-span-2">
                    <label for="leader" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID ou Email do Líder</label>
                    <input type="text" name="leader" id="leader"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
                </div>

                <div class="col-span-2">
                    <label for="vice_leader" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID ou Email do Vice-Líder</label>
                    <input type="text" name="vice_leader" id="vice_leader"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white">
                </div>

            </div>
            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-4 py-2.5 text-sm font-medium text-center">
                <i class="fas fa-graduation-cap mr-2"></i> Cadastrar
            </button>
        </form>
    </div>
</div>