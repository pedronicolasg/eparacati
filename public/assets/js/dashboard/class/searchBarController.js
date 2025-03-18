function getCellText(row, selector) {
  return row.querySelector(selector)?.textContent.toLowerCase().trim() || '';
}

function matchesSearchTerm(row, searchTerm) {
  const fields = [
    'td:first-child .font-medium',
    'td:nth-child(2)',
    'td:nth-child(3) .font-medium',
    'td:nth-child(3) .text-gray-500',
    'td:nth-child(3)',
    'td:nth-child(4) .font-medium',
    'td:nth-child(4) .text-gray-500',
    'td:nth-child(4)',
    'td:nth-child(5) .font-medium',
    'td:nth-child(5) .text-gray-500',
    'td:nth-child(5)'
  ];

  return fields.some(selector => getCellText(row, selector).includes(searchTerm));
}

function filterRows(tableRows, searchTerm) {
  tableRows.forEach(row => {
    if (row.classList.contains('no-results')) return;
    row.style.display = matchesSearchTerm(row, searchTerm) ? '' : 'none';
  });
}

function handleNoResultsMessage(tableRows, searchTerm) {
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
        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
          Nenhum resultado encontrado para "${searchTerm}"
        </td>
      `;
      tbody.appendChild(newRow);
    }
  } else if (noResultsRow) {
    noResultsRow.remove();
  }
}

function searchTable() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar turmas"]');
  const tableRows = document.querySelectorAll('table tbody tr');

  searchInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase().trim();
    filterRows(tableRows, searchTerm);
    handleNoResultsMessage(tableRows, searchTerm);
  });
}

document.addEventListener('DOMContentLoaded', searchTable);
