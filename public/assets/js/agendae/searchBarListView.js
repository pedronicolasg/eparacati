function searchEquipmentList() {
  const searchInput = document.querySelector('div.flex.flex-col.sm\\:flex-row.gap-3 input[placeholder="Buscar equipamento..."]');


  const equipmentContainer = document.querySelector('div.space-y-4');

  if (!searchInput || !equipmentContainer) return;

  const equipmentCards = equipmentContainer.querySelectorAll('.flex.flex-col.sm\\:flex-row.items-start.sm\\:items-center.justify-between.p-4.bg-white.dark\\:bg-gray-800.rounded-lg.shadow-md.mb-4');

  const getTextContent = (element, selector) => {
    const el = element.querySelector(selector);
    return el ? el.textContent.toLowerCase().trim() : '';
  };

  const filterCards = (searchTerm) => {
    let hasVisibleCards = false;

    equipmentCards.forEach(card => {
      const name = getTextContent(card, 'h3.font-medium.text-lg.sm\\:text-base.truncate');
      const category = getTextContent(card, 'span.bg-purple-600, span.bg-indigo-600');
      const description = getTextContent(card, 'p.text-sm.text-gray-600.dark\\:text-gray-400.line-clamp-2');

      const matches = searchTerm === '' ||
        [name, category, description].some(text => text.includes(searchTerm));
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
        noResultsDiv.className = 'no-results';
        noResultsDiv.innerHTML = `
          <p class="text-center text-gray-500 dark:text-gray-400 py-4">
            Nenhum resultado encontrado para "${searchTerm}"
          </p>
        `;
        equipmentContainer.appendChild(noResultsDiv);
      }
    } else if (noResultsDiv) {
      noResultsDiv.remove();
    }
  };

  searchInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase().trim();
    const hasResults = filterCards(searchTerm);
    handleNoResults(searchTerm, hasResults);
  });

  const urlParams = new URLSearchParams(window.location.search);
  if (!urlParams.has('search')) {
    searchInput.value = '';
    filterCards('');
  }
}

document.addEventListener('DOMContentLoaded', searchEquipmentList);