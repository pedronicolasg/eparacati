<div id="userAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-200/70 dark:bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0 overflow-y-auto py-10">
    <div class="relative w-full max-w-md max-h-[90vh] overflow-y-auto bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-purple-500/10 scrollbar-thin scrollbar-thumb-blue-400 dark:scrollbar-thumb-blue-700 scrollbar-track-blue-100 dark:scrollbar-track-blue-900">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 dark:border-purple-500/10 bg-gray-50 dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center">
                    <i class="fas fa-user-plus text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-300 transition-colors">
                    Cadastrar novo usuário
                </h3>
            </div>
            <button onclick="closeUserAddModal()" id="useradd-close-modal-btn" type="button"
                class="text-gray-500 bg-gray-100 hover:bg-purple-100 hover:text-purple-600 dark:text-gray-400 dark:bg-gray-800/50 dark:hover:bg-purple-500/20 dark:hover:text-purple-300 rounded-lg text-sm w-8 h-8 flex items-center justify-center transition-all duration-300">
                <i class="fas fa-times"></i>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form action="../../src/controllers/user/register.php" method="POST" class="p-5 space-y-6">
            <div class="space-y-5">
                <div class="relative">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-user text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <input type="text" name="name" id="name"
                            class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Nome completo do usuário" required>
                    </div>
                </div>

                <div class="relative">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-envelope text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <input type="email" name="email" id="email"
                            class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Email do usuário" autocomplete="email" required>
                    </div>
                </div>

                <div class="relative">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-phone text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <input type="tel" name="phone" id="phone"
                            class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="(00) 00000-0000" maxlength="15" onkeyup="handlePhoneNumber(event)" onblur="formatPhoneNumber(event)" required>
                    </div>
                </div>

                <div class="relative">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-lock text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <input type="password" name="password" id="password"
                            class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 placeholder:text-gray-400 dark:placeholder:text-gray-500"
                            placeholder="Senha do usuário" required>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="relative">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-id-badge text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <select required type="role" id="role" name="role" onchange="toggleClassSelector()"
                                class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 appearance-none">
                                <option value="" select>Selecione</option>
                                <option value="aluno">Aluno</option>
                                <option value="professor">Professor</option>
                                <option value="gestao">Gestão</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-purple-600 dark:text-purple-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="relative" id="class-selector" style="display: none;">
                        <label for="class" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Turma</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="fas fa-graduation-cap text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <select id="class" name="class"
                                class="bg-white dark:bg-slate-800/50 border border-gray-300 dark:border-slate-700 text-gray-800 dark:text-white text-sm rounded-xl w-full pl-10 p-3 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/30 transition-all duration-300 appearance-none">
                                <option value="" selected>Selecionar</option>
                                <?php
                                $classes = $classModel->get();

                                foreach ($classes as $class): ?>
                                    <option value="<?= $class['id']; ?>"><?= $class['name']; ?> (<?= $class['grade']?>ª Série)</option>
                                <?php endforeach; ?>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-purple-600 dark:text-purple-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-xl px-5 py-3.5 text-sm font-medium text-center transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-purple-500/50 flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-user-plus"></i> Cadastrar Usuário
            </button>
        </form>
    </div>
</div>

<script>
    function toggleClassSelector() {
        var roleSelector = document.getElementById('role');
        var classSelector = document.getElementById('class-selector');
        var classSelect = document.getElementById('class');
        if (roleSelector.value === 'aluno') {
            classSelector.style.display = 'block';
        } else {
            classSelector.style.display = 'none';
            classSelect.selectedIndex = 0;
        }
    }

    function handlePhoneNumber(event) {
        let input = event.target;
        input.value = input.value.replace(/\D/g, '');
    }

    function formatPhoneNumber(event) {
        let input = event.target;
        let value = input.value.replace(/\D/g, '');

        if (value.length > 11) {
            value = value.substring(0, 11);
        }

        let formattedValue = '';
        if (value.length > 0) {
            if (value.length <= 2) {
                formattedValue = '(' + value;
            } else {
                formattedValue = '(' + value.substring(0, 2) + ')';
                if (value.length > 2) {
                    formattedValue += ' ' + value.substring(2, 7);
                    if (value.length > 7) {
                        formattedValue += '-' + value.substring(7);
                    }
                }
            }
        }

        input.value = formattedValue;
    }
</script>