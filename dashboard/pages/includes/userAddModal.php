<div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-300 ease-in-out opacity-0">
    <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-700">
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Cadastrar novo usuário
            </h3>
            <button onclick="closeModal()" id="close-modal-btn" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" aria-hidden="true">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6-6M7 7l6 6m-6-6L1 13"/>
                </svg>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Nome completo do usuário" required>
                </div>
                <div class="col-span-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Email do usuário" required>
                </div>
                <div class="col-span-2">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
                    <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Senha do usuário" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
                    <select id="role" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option value="aluno" selected>Aluno</option>
                        <option value="professor">Professor</option>
                        <option value="gestao">Gestão</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="class" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Turma</label>
                    <select id="class" class="bg-gray-50 border border-gray-300 text-sm rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        <option selected>Selecione</option>
                        <!--Adicionar dps a lógica de listar as turmas e de ignorar se o usuário = !aluno-->
                    </select>
                </div>
            </div>
            <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-4 py-2.5 text-sm font-medium text-center">
                <i class="fas fa-user-plus mr-2"></i> Cadastrar
            </button>
        </form>
    </div>
</div>
