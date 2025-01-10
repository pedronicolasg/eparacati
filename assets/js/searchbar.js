function searchTable() {
  const searchInput = document.querySelector('input[placeholder="Pesquisar usuários"]');
  const tableRows = document.querySelectorAll('table tbody tr');

  searchInput.addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase().trim();

    tableRows.forEach(row => {
      const name = row.querySelector('td:first-child .font-medium')?.textContent.toLowerCase().trim() || '';
      const id = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase().trim() || '';
      const email = row.querySelector('td:first-child .text-gray-500')?.textContent.toLowerCase().trim() || '';
      const className = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase().trim() || '';

      const matches = name.includes(searchTerm) ||
        id.includes(searchTerm) ||
        email.includes(searchTerm) ||
        className.includes(searchTerm);

      row.style.display = matches ? '' : 'none';
    });

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
  });
}

document.addEventListener('DOMContentLoaded', searchTable);