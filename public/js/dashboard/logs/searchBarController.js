document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const tableRows = document.querySelectorAll('tbody tr');
  const clearButton = document.querySelector('.absolute.inset-y-0.right-0.pr-3 button');
  
  const filterTable = (searchTerm) => {
    searchTerm = searchTerm.toLowerCase().trim();
    
    let visibleRows = 0;
    tableRows.forEach(row => {
      const text = row.textContent.toLowerCase();
      if (searchTerm === '' || text.includes(searchTerm)) {
        row.style.display = '';
        visibleRows++;
      } else {
        row.style.display = 'none';
      }
    });
    
    const noResultsRow = document.querySelector('tr td[colspan="8"]')?.closest('tr');
    if (noResultsRow) {
      noResultsRow.style.display = visibleRows === 0 ? '' : 'none';
    }
  };
  
  const clearSearch = () => {
    if (searchInput) {
      searchInput.value = '';
      filterTable('');
      searchInput.focus();
    }
  };
  
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      filterTable(searchInput.value);
    });
    
    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        filterTable(searchInput.value);
      } else if (e.key === 'Escape') {
        clearSearch();
      }
    });
    
    searchInput.value = '';
  }

  if (clearButton) {
    clearButton.addEventListener('click', clearSearch);
  }
  
  filterTable('');
});
