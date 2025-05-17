function searchEquipment() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar agendamentos"]');
  const equipmentContainer = document.querySelector('.grid') || document.querySelector('.equipment-container');

  if (!searchInput || !equipmentContainer) return;

  const equipmentCards = document.querySelectorAll('.group.relative.overflow-hidden.bg-white.dark\\:bg-gray-800.rounded-2xl');

  const getTextContent = (element, selector) => {
    const el = element.querySelector(selector);
    return el ? el.textContent.toLowerCase().trim() : '';
  };

  const filterCards = (searchTerm) => {
    let hasVisibleCards = false;

    equipmentCards.forEach(card => {
      const name = getTextContent(card, 'h3');
      const type = getTextContent(card, '.inline-flex.items-center.px-2\\.5.py-1.rounded-full.text-xs.font-medium');
      const description = getTextContent(card, 'p.text-sm.text-gray-600.dark\\:text-gray-400');
      const date = getTextContent(card, '.flex.items-center.space-x-1.text-xs');
      const time = getTextContent(card, '.flex.items-center.space-x-1\\.5.text-xs.font-medium.text-gray-700');
      const userName = getTextContent(card, '.flex.items-center.space-x-1\\.5.text-xs.font-medium a');
      const className = getTextContent(card, '.flex.items-center.space-x-1\\.5.text-xs.font-medium.text-emerald-600 span:last-child');
      const note = getTextContent(card, '.text-xs.text-gray-600.dark\\:text-gray-400.italic');

      const matches = searchTerm === '' ||
        [name, type, description, date, time, userName, className, note].some(text => text.includes(searchTerm));
      
      card.style.display = matches ? '' : 'none';
      if (matches) hasVisibleCards = true;
    });

    return hasVisibleCards;
  };

  const handleNoResults = (searchTerm, hasResults) => {
    let noResultsDiv = equipmentContainer.querySelector('.no-results');

    if (!hasResults && searchTerm !== '') {
      if (!noResultsDiv) {
        noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-results col-span-full py-8';
        noResultsDiv.innerHTML = `
          <div class="text-center max-w-md mx-auto">
            <div class="mb-4 text-gray-400 dark:text-gray-500">
              <i class="fas fa-search fa-3x"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-2">Nenhum resultado encontrado</h3>
            <p class="text-gray-500 dark:text-gray-400">Não encontramos agendamentos para "${searchTerm}"</p>
          </div>
        `;
        equipmentContainer.appendChild(noResultsDiv);
      }
    } else if (noResultsDiv) {
      noResultsDiv.remove();
    }
  };

  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    const hasResults = filterCards(searchTerm);
    handleNoResults(searchTerm, hasResults);
  });
}

document.addEventListener('DOMContentLoaded', searchEquipment);
