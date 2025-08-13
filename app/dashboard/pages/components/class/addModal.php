<div id="classAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-200/70 dark:bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0 overflow-y-auto py-10">
    <div class="relative w-full max-w-md max-h-[90vh] overflow-y-auto bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-green-500/10 scrollbar-thin scrollbar-thumb-blue-400 dark:scrollbar-thumb-blue-700 scrollbar-track-blue-100 dark:scrollbar-track-blue-900">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-green-500/10 bg-gray-50 dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-500/20 flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-300 transition-colors">
                    Cadastrar nova Turma
                </h3>
            </div>
            <button onclick="closeclassAddModal()" id="classadd-close-modal-btn" type="button"
                class="text-gray-500 bg-gray-100 hover:bg-green-100 hover:text-green-600 dark:text-gray-400 dark:bg-gray-800/50 dark:hover:bg-green-500/20 dark:hover:text-green-300 rounded-lg text-sm w-8 h-8 flex items-center justify-center transition-all duration-300">
                <i class="fas fa-times"></i>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form action="../../src/controllers/class/create.php" method="POST" class="p-5 space-y-6">
            <div class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="relative">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Curso/Nome*</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-book text-green-600 dark:text-green-400"></i>
                            </div>
                            <input type="text" name="name" id="name"
                                class="bg-white border border-gray-300 text-gray-800 dark:bg-slate-800/50 dark:border-slate-700 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                                placeholder="Ex: Informática C" required>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <label for="grade" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Ano*</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-green-600 dark:text-green-400"></i>
                            </div>
                            <select id="grade" name="grade" type="grade"
                                class="bg-white border border-gray-300 text-gray-800 dark:bg-slate-800/50 dark:border-slate-700 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all duration-300 appearance-none" required>
                                <option selected>Selecione</option>
                                <option value="1">1º Ano</option>
                                <option value="2">2º Ano</option>
                                <option value="3">3º Ano</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-green-600 dark:text-green-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <label for="pdt" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ID ou Email do PDT</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-chalkboard-teacher text-green-600 dark:text-green-400"></i>
                        </div>
                        <input type="text" name="pdt" id="pdt"
                            class="bg-white border border-gray-300 text-gray-800 dark:bg-slate-800/50 dark:border-slate-700 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="professor@email.com">
                    </div>
                </div>

                <div class="relative">
                    <label for="leader" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ID ou Email do Líder</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user-tie text-green-600 dark:text-green-400"></i>
                        </div>
                        <input type="text" name="leader" id="leader"
                            class="bg-white border border-gray-300 text-gray-800 dark:bg-slate-800/50 dark:border-slate-700 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="lider@email.com">
                    </div>
                </div>

                <div class="relative">
                    <label for="vice_leader" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">ID ou Email do Vice-Líder</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user-friends text-green-600 dark:text-green-400"></i>
                        </div>
                        <input type="text" name="vice_leader" id="vice_leader"
                            class="bg-white border border-gray-300 text-gray-800 dark:bg-slate-800/50 dark:border-slate-700 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-green-500 focus:ring-2 focus:ring-green-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="vicelider@email.com">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-xl px-5 py-3.5 text-sm font-medium text-center transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-green-500/50 flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-graduation-cap"></i> Cadastrar Turma
            </button>
        </form>
    </div>
</div>