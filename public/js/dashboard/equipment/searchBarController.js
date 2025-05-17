function searchEquipment() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar equipamentos"]');
  const equipmentCards = document.querySelectorAll('.equipment-card');

  const getTextContent = (element, selector) => element.querySelector(selector)?.textContent.toLowerCase().trim() || '';

  const filterCards = (searchTerm) => {
    equipmentCards.forEach(card => {
      const name = getTextContent(card, 'h2.text-xl.font-bold');
      const category = getTextContent(card, '.fas.fa-tag').replace('tag', '').trim();
      const description = getTextContent(card, '.text-gray-600.dark\\:text-gray-300.text-sm');

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
        newDiv.className = 'no-results col-span-full';
        newDiv.innerHTML = `
          <div class="flex flex-col items-center justify-center py-8 text-center">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
              <i class="fas fa-search text-2xl text-gray-400 dark:text-gray-500"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Nenhum resultado encontrado</h3>
            <p class="text-gray-500 dark:text-gray-400">
              Não encontramos equipamentos para "${searchTerm}"
            </p>
          </div>
        `;
        container.appendChild(newDiv);
      } else {
        const messageElement = noResultsDiv.querySelector('p');
        if (messageElement) {
          messageElement.textContent = `Não encontramos equipamentos para "${searchTerm}"`;
        }
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
