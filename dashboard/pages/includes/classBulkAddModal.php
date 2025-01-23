<div id="classBulkAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 transition-opacity duration-300 ease-in-out opacity-0">
    <div class="relative w-full max-w-md max-h-full bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Cadastrar várias Turmas
            </h3>
            <button onclick="closeclassBulkAddModal()" id="bulkclassadd-close-modal-btn" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" aria-hidden="true">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1l6 6m0 0l6-6M7 7l6 6m-6-6L1 13" />
                </svg>
                <span class="sr-only">Fechar</span>
            </button>
        </div>


        <form action="../../methods/handlers/class/bulkCreate.php" method="POST" enctype="multipart/form-data"
            class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <a href="../../assets/docs/Modelo_Cadastro_Turmas.xlsx" type="button"
                        class="py-2 px-3 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-blue-600 dark:border-blue-600 dark:hover:text-white dark:hover:bg-blue-700">
                        <svg class="w-3 h-3 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                            <path
                                d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                        Planilha Modelo
                    </a>
                </div>
                <div class="col-span-2">

                    <label for="excel_file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Planilha
                        Excel:</label>
                    <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls" required class="block w-full text-sm text-gray-500
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
            </div>
            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 rounded-lg px-4 py-2.5 text-sm font-medium text-center">
                <i class="fas fa-user-plus mr-2"></i> Cadastrar
            </button>
        </form>


    </div>
</div>