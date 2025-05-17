document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('input[placeholder="Buscar equipamento..."]');
    if (!searchInput) return;

    const listContainer = document.querySelector('.space-y-4, .flex.flex-col.gap-4');
    if (!listContainer) return;

    const equipmentItems = listContainer.querySelectorAll('div.border-l-4');
    if (equipmentItems.length === 0) return;

    function filterEquipments(searchTerm) {
        searchTerm = searchTerm.toLowerCase().trim();
        let visibleCount = 0;

        equipmentItems.forEach(item => {
            const nameElement = item.querySelector('h3');
            const descriptionElement = item.querySelector('p.text-sm.text-gray-600, p.text-sm.text-gray-400');

            const name = nameElement ? nameElement.textContent.toLowerCase() : '';
            const description = descriptionElement ? descriptionElement.textContent.toLowerCase() : '';

            const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);

            if (matchesSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        const noResultsMessage = document.getElementById('no-results-message');
        if (visibleCount === 0 && searchTerm !== '') {
            if (!noResultsMessage) {
                const message = document.createElement('div');
                message.id = 'no-results-message';
                message.className = 'w-full text-center py-8';
                message.innerHTML = `
          <div class="flex flex-col items-center justify-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-4">
              <i class="fas fa-search text-slate-400 dark:text-slate-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-medium text-slate-700 dark:text-slate-300 mb-2">Nenhum equipamento encontrado</h3>
            <p class="text-slate-500 dark:text-slate-400">Tente outros termos de pesquisa</p>
          </div>
        `;
                listContainer.appendChild(message);
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }

    searchInput.addEventListener('input', function () {
        filterEquipments(this.value);
    });

    filterEquipments(searchInput.value);
})