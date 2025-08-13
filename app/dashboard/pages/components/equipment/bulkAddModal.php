<div id="equipmentBulkAddModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-200/70 dark:bg-gray-900/70 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0 overflow-y-auto py-10">
    <div class="relative w-full max-w-md max-h-[90vh] overflow-y-auto bg-white dark:bg-gradient-to-br dark:from-slate-900 dark:to-slate-800 rounded-2xl shadow-2xl border border-cyan-500/20 dark:border-cyan-500/10 scrollbar-thin scrollbar-thumb-blue-400 dark:scrollbar-thumb-blue-700 scrollbar-track-blue-100 dark:scrollbar-track-blue-900">
        <div class="flex items-center justify-between p-5 border-b border-cyan-500/20 dark:border-cyan-500/10 bg-gray-50 dark:bg-slate-900">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-cyan-100 dark:bg-cyan-500/20 flex items-center justify-center">
                    <i class="fas fa-file-import text-cyan-600 dark:text-cyan-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white group-hover:text-cyan-600 dark:group-hover:text-cyan-300 transition-colors">
                    Importar Equipamentos
                </h3>
            </div>
            <button onclick="closeEquipmentBulkAddModal()" id="bulkequipmentadd-close-modal-btn" type="button"
                class="text-gray-500 bg-gray-100 hover:bg-cyan-100 hover:text-cyan-600 dark:text-gray-400 dark:bg-gray-800/50 dark:hover:bg-cyan-500/20 dark:hover:text-cyan-300 rounded-lg text-sm w-8 h-8 flex items-center justify-center transition-all duration-300">
                <i class="fas fa-times"></i>
                <span class="sr-only">Fechar</span>
            </button>
        </div>

        <form action="../../src/controllers/equipment/bulkregister.php" method="POST" enctype="multipart/form-data" class="p-5 space-y-6">
            <div class="bg-gray-50 dark:bg-slate-800/50 rounded-2xl p-6 border border-gray-200 dark:border-white/5 mb-6">
                <div class="text-center mb-6">
                    <p class="text-gray-700 dark:text-gray-300">Importe vários equipamentos de uma só vez usando uma planilha.</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Formatos suportados: XLSX, CSV</p>
                </div>

                <div class="bg-white dark:bg-slate-800/70 rounded-2xl p-5 border border-gray-200 dark:border-white/5 hover:border-cyan-500/30 transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-cyan-100 dark:bg-cyan-500/20 flex items-center justify-center">
                            <i class="fas fa-laptop text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <h3 class="font-medium text-gray-800 dark:text-white">Equipamentos Iniciais</h3>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Importe uma planilha com os equipamentos para cadastro em massa.</p>
                    <div class="file-upload-container">
                        <label class="relative block w-full">
                            <input type="file" accept=".csv, .xlsx" name="excel_file" id="excel_file" class="sr-only peer file-input" data-type="equipment" required />
                            <div class="h-20 w-full border-2 border-dashed border-gray-300 dark:border-gray-600 peer-hover:border-cyan-500/50 rounded-xl flex flex-col items-center justify-center cursor-pointer transition-all duration-300 upload-area">
                                <i class="fas fa-cloud-upload text-gray-500 dark:text-gray-500 peer-hover:text-cyan-600 dark:peer-hover:text-cyan-400 text-xl mb-1 transition-colors"></i>
                                <span class="text-xs text-gray-500 dark:text-gray-500 peer-hover:text-gray-800 dark:peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
                            </div>
                        </label>
                        <div class="file-info hidden mt-3 px-2"></div>
                    </div>
                </div>
            </div>

            <div class="bg-sky-100 dark:bg-sky-500/10 border border-sky-200 dark:border-sky-500/20 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="text-sky-600 dark:text-sky-400 mt-1">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-gray-800 dark:text-white font-medium">Dica para importação</h4>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Para facilitar a importação, baixe nosso modelo de planilha e preencha com seus dados antes de
                            fazer o upload.
                        </p>
                        <div class="mt-3">
                            <a href="../../../public/templates/spreadsheet/Modelo_Cadastro_Equipamentos.xlsx" download class="text-sm flex items-center gap-2 text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 dark:hover:text-cyan-300 transition-colors bg-cyan-100 dark:bg-cyan-500/10 hover:bg-cyan-200 dark:hover:bg-cyan-500/20 rounded-lg px-4 py-2 w-fit">
                                <i class="fas fa-download"></i>
                                <span>Baixar Modelo de Planilha</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full text-white bg-gradient-to-r from-cyan-600 to-cyan-700 hover:from-cyan-700 hover:to-cyan-800 rounded-xl px-5 py-3.5 text-sm font-medium text-center transition-all duration-300 transform hover:scale-[1.02] focus:ring-2 focus:ring-cyan-500/50 flex items-center justify-center gap-2 shadow-lg">
                <i class="fas fa-file-import"></i> Importar Equipamentos
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('#equipmentBulkAddModal .file-input');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const container = this.closest('.file-upload-container');
                const fileInfo = container.querySelector('.file-info');
                const uploadArea = container.querySelector('.upload-area');
                const fileType = this.dataset.type;

                const extension = file.name.split('.').pop().toLowerCase();
                if (extension !== 'csv' && extension !== 'xlsx') {
                    alert('Por favor, selecione um arquivo CSV ou XLSX.');
                    return;
                }

                uploadArea.innerHTML = '';
                const uploadIcon = document.createElement('i');
                uploadIcon.className = 'fas fa-check-circle text-2xl text-cyan-600 dark:text-cyan-400';
                uploadArea.classList.add('border-cyan-500');

                uploadArea.appendChild(uploadIcon);
                uploadArea.classList.remove('border-dashed');
                uploadArea.classList.add('border-solid');

                fileInfo.innerHTML = '';
                fileInfo.classList.remove('hidden');

                const fileIcon = document.createElement('i');
                if (extension === 'csv') {
                    fileIcon.className = 'fas fa-file-csv mr-2 text-cyan-600 dark:text-cyan-400';
                } else {
                    fileIcon.className = 'fas fa-file-excel mr-2 text-cyan-600 dark:text-cyan-400';
                }

                const fileName = document.createElement('span');
                fileName.className = 'text-sm text-gray-800 dark:text-gray-300';
                fileName.textContent = file.name;

                const fileSize = document.createElement('span');
                fileSize.className = 'text-xs text-gray-500 dark:text-gray-500 ml-2';

                const size = file.size;
                let formattedSize;
                if (size < 1024) {
                    formattedSize = size + ' B';
                } else if (size < 1024 * 1024) {
                    formattedSize = (size / 1024).toFixed(1) + ' KB';
                } else {
                    formattedSize = (size / (1024 * 1024)).toFixed(1) + ' MB';
                }

                fileSize.textContent = `(${formattedSize})`;

                const removeBtn = document.createElement('button');
                removeBtn.className = 'ml-auto text-gray-500 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.type = 'button';

                removeBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    uploadArea.innerHTML = `
                    <i class="fas fa-cloud-upload text-gray-500 dark:text-gray-500 peer-hover:text-cyan-600 dark:peer-hover:text-cyan-400 text-xl mb-1 transition-colors"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-500 peer-hover:text-gray-800 dark:peer-hover:text-gray-300 transition-colors">Clique para selecionar</span>
                `;
                    uploadArea.classList.add('border-dashed');
                    uploadArea.classList.remove('border-solid', 'border-cyan-500');
                    fileInfo.classList.add('hidden');
                });

                const fileInfoContent = document.createElement('div');
                fileInfoContent.className = 'flex items-center';
                fileInfoContent.appendChild(fileIcon);
                fileInfoContent.appendChild(fileName);
                fileInfoContent.appendChild(fileSize);
                fileInfoContent.appendChild(removeBtn);
                fileInfo.appendChild(fileInfoContent);
            });
        }
    });
</script>