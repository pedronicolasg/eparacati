<div id="equipmentAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-200/70 dark:bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0 overflow-y-auto py-10">
    <div class="relative w-full max-w-md max-h-[90vh] overflow-y-auto bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-cyan-500/10">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-cyan-500/10 bg-gray-50 dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-cyan-100 dark:bg-cyan-500/20 flex items-center justify-center">
                    <i class="fas fa-laptop text-cyan-600 dark:text-cyan-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-300 transition-colors">
                    Cadastrar novo Equipamento
                </h3>
            </div>
            <button onclick="closeequipmentAddModal()" id="equipmentadd-close-modal-btn" type="button"
                class="text-gray-500 bg-gray-100 hover:bg-cyan-100 hover:text-cyan-600 dark:text-gray-400 dark:bg-gray-800/50 dark:hover:bg-cyan-500/20 dark:hover:text-cyan-300 rounded-lg text-sm w-8 h-8 flex items-center justify-center transition-all duration-300">
                <i class="fas fa-times"></i>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form action="../../src/controllers/equipment/register.php" method="POST" enctype="multipart/form-data" class="p-5 space-y-6">
            <div class="space-y-5">
                <div class="relative">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-laptop text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <input type="text" name="name" id="name"
                            class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Ex: Notebook #17" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="relative">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-tag text-cyan-600 dark:text-cyan-400"></i>
                            </div>
                            <select id="type" name="type" type="type"
                                class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30 transition-all duration-300 appearance-none">
                                <option selected>Selecione</option>
                                <?php foreach ($equipmentModel->getTypes() as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars(Format::typeName($type)) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-cyan-600 dark:text-cyan-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-circle text-cyan-600 dark:text-cyan-400"></i>
                            </div>
                            <select id="status" name="status" type="status"
                                class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30 transition-all duration-300 appearance-none">
                                <option value="disponivel" selected>Disponível</option>
                                <option value="indisponivel">Indisponível</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-cyan-600 dark:text-cyan-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Imagem</label>
                    <div class="relative">
                        <input type="file" name="image" id="image" accept=".png, .jpeg, .jpg, .webp" required
                            class="block w-full text-sm text-gray-800 dark:text-gray-300 bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 rounded-xl p-3 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-cyan-500/20 file:text-cyan-600 dark:file:text-cyan-400 hover:file:bg-cyan-500/30 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30 transition-all duration-300">
                    </div>
                </div>

                <div class="relative">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                    <textarea id="description" name="description" rows="4"
                        class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full p-3 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                        placeholder="Descreva o equipamento..."></textarea>
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 rounded-xl px-5 py-3.5 text-sm font-medium text-center transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-cyan-500/50 flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-plus"></i> Cadastrar Equipamento
            </button>
        </form>
    </div>
</div>