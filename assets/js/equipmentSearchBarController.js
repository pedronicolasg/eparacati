function searchEquipment() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar equipamentos"]');
  const equipmentCards = document.querySelectorAll('.bg-white.dark\\:bg-gray-800.rounded-lg.shadow-md.overflow-hidden.transition-colors.duration-300');

  const getTextContent = (element, selector) => element.querySelector(selector)?.textContent.toLowerCase().trim() || '';

  const filterCards = (searchTerm) => {
    equipmentCards.forEach(card => {
      const name = getTextContent(card, 'h2');
      const category = getTextContent(card, 'p.text-sm.text-gray-500.dark\\:text-gray-400.mb-3');
      const description = getTextContent(card, 'p.text-gray-600.dark\\:text-gray-300.mb-4');

      const matches = [name, category, description].some(text => text.includes(searchTerm));
      card.style.display = matches ? '' : 'none';
    });
  };

  const handleNoResults = (searchTerm) => {
    const visibleCards = [...equipmentCards].filter(card => card.style.display !== 'none');
    const noResultsDiv = document.querySelector('.no-results');

    if (visibleCards.length === 0) {
      if (!noResultsDiv) {
        const container = document.querySelector('.equipment-container');
        const newDiv = document.createElement('div');
        newDiv.className = 'no-results';
        newDiv.innerHTML = `
          <p class="text-center text-gray-500 dark:text-gray-400">
            Nenhum resultado encontrado para "${searchTerm}"
          </p>
        `;
        container.appendChild(newDiv);
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
