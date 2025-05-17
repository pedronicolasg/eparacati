document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('search-classes');
  let debounceTimeout;

  function updateURL(searchTerm, grade) {
    const url = new URL(window.location);
    url.searchParams.set('page', '1');
    if (searchTerm) {
      url.searchParams.set('search', searchTerm);
    } else {
      url.searchParams.delete('search');
    }
    if (grade) {
      url.searchParams.set('grade', grade);
    } else {
      url.searchParams.delete('grade');
    }
    window.history.pushState({}, '', url);
    window.location.reload();
  }

  searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimeout);
    const searchTerm = this.value.trim();
    debounceTimeout = setTimeout(() => {
      updateURL(searchTerm, new URLSearchParams(window.location.search).get('grade'));
    }, 300);
  });

  searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      clearTimeout(debounceTimeout);
      updateURL(this.value.trim(), new URLSearchParams(window.location.search).get('grade'));
    }
  });

  searchInput.addEventListener('change', function () {
    if (!this.value.trim()) {
      updateURL('', new URLSearchParams(window.location.search).get('grade'));
    }
  });
});