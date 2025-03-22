function searchEquipment() {
  const searchInput = document.querySelector('input[placeholder="Buscar equipamento..."]');
  const equipmentContainer = document.querySelector('.grid.grid-cols-1');
  const equipmentCards = equipmentContainer.querySelectorAll('.relative.bg-white.dark\\:bg-gray-800.rounded-xl.overflow-hidden.shadow-md');

  const getTextContent = (element, selector) => element.querySelector(selector)?.textContent.toLowerCase().trim() || '';

  const filterCards = (searchTerm) => {
    equipmentCards.forEach(card => {
      const name = getTextContent(card, 'h3');
      const category = getTextContent(card, 'span.bg-purple-600');
      const description = getTextContent(card, 'p.text-sm.text-gray-600.dark\\:text-gray-400.mb-3');

      const matches = [name, category, description].some(text => text.includes(searchTerm));
      card.style.display = matches ? '' : 'none';
    });
  };

  const handleNoResults = (searchTerm) => {
    const visibleCards = [...equipmentCards].filter(card => card.style.display !== 'none');
    const noResultsDiv = document.querySelector('.no-results');

    if (visibleCards.length === 0) {
      if (!noResultsDiv) {
        const newDiv = document.createElement('div');
        newDiv.className = 'no-results';
        newDiv.innerHTML = `
          <p class="text-center text-gray-500 dark:text-gray-400">
            Nenhum resultado encontrado para "${searchTerm}"
          </p>
        `;
        equipmentContainer.appendChild(newDiv);
      }
    } else if (noResultsDiv) {
      noResultsDiv.remove();
    }
  };

  searchInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase().trim();
    filterCards(searchTerm);
    handleNoResults(searchTerm);
  });
}

document.addEventListener('DOMContentLoaded', searchEquipment);
