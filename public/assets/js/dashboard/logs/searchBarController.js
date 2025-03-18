function searchLogs() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar registros"]');
  const tableRows = document.querySelectorAll('tbody tr');

  const filterRows = (searchTerm) => {
    tableRows.forEach(row => {
      const cells = row.querySelectorAll('td');
      const matches = [...cells].some(cell => cell.textContent.toLowerCase().includes(searchTerm));
      row.style.display = matches ? '' : 'none';
    });
  };

  const handleNoResults = (searchTerm) => {
    const visibleRows = [...tableRows].filter(row => row.style.display !== 'none');
    const noResultsDiv = document.querySelector('.no-results');

    if (visibleRows.length === 0) {
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
    filterRows(searchTerm);
    handleNoResults(searchTerm);
  });
}

document.addEventListener('DOMContentLoaded', searchLogs);
