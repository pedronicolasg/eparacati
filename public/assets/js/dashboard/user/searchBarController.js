function searchTable() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar usuários"]');
  const tableRows = document.querySelectorAll('table tbody tr');

  const getTextContent = (row, selector) => {
    const element = row.querySelector(selector);
    return element ? element.textContent.toLowerCase().trim() : '';
  };

  const filterRows = (searchTerm) => {
    tableRows.forEach(row => {
      if (row.classList.contains('no-results')) return;
      
      const name = getTextContent(row, 'td:first-child .text-sm.font-semibold');
      const id = getTextContent(row, 'td:nth-child(2)');
      const email = getTextContent(row, 'td:first-child .text-gray-500, td:first-child .text-gray-400');
      const role = getTextContent(row, 'td:nth-child(3) span');
      const className = getTextContent(row, 'td:nth-child(4) a');
      const phone = getTextContent(row, 'td:first-child .fas.fa-phone').replace(/\s+/g, '');

      const matches = [name, id, email, role, className, phone].some(text => text.includes(searchTerm));
      row.style.display = matches ? '' : 'none';
    });
  };

  const handleNoResults = (searchTerm) => {
    const visibleRows = [...tableRows].filter(row => 
      !row.classList.contains('no-results') && row.style.display !== 'none'
    );
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