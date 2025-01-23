function searchTable() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar usuários"]');
  const tableRows = document.querySelectorAll('table tbody tr');

  const getTextContent = (row, selector) => row.querySelector(selector)?.textContent.toLowerCase().trim() || '';

  const filterRows = (searchTerm) => {
    tableRows.forEach(row => {
      const name = getTextContent(row, 'td:first-child .font-medium');
      const id = getTextContent(row, 'td:nth-child(2)');
      const email = getTextContent(row, 'td:first-child .text-gray-500');
      const className = getTextContent(row, 'td:nth-child(4)');

      const matches = [name, id, email, className].some(text => text.includes(searchTerm));
      row.style.display = matches ? '' : 'none';
    });
  };

  const handleNoResults = (searchTerm) => {
    const visibleRows = [...tableRows].filter(row => row.style.display !== 'none');
    const noResultsRow = document.querySelector('tr.no-results');

    if (visibleRows.length === 0) {
      if (!noResultsRow) {
        const tbody = document.querySelector('table tbody');
        const newRow = document.createElement('tr');
        newRow.className = 'no-results';
        newRow.innerHTML = `
          <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
            Nenhum resultado encontrado para "${searchTerm}"
          </td>
        `;
        tbody.appendChild(newRow);
      }
    } else if (noResultsRow) {
      noResultsRow.remove();
    }
  };

  searchInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase().trim();
    filterRows(searchTerm);
    handleNoResults(searchTerm);
  });
}

document.addEventListener('DOMContentLoaded', searchTable);