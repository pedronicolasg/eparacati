document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('search-users');
  let debounceTimeout;

  function updateURL(searchTerm, role) {
    const url = new URL(window.location);
    url.searchParams.set('page', '1');
    if (searchTerm) {
      url.searchParams.set('search', searchTerm);
    } else {
      url.searchParams.delete('search');
    }
    if (role) {
      url.searchParams.set('role', role);
    } else {
      url.searchParams.delete('role');
    }
    window.history.pushState({}, '', url);
    window.location.reload();
  }

  searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimeout);
    const searchTerm = this.value.trim();
    debounceTimeout = setTimeout(() => {
      updateURL(searchTerm, new URLSearchParams(window.location.search).get('role'));
    }, 300);
  });

  searchInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      clearTimeout(debounceTimeout);
      updateURL(this.value.trim(), new URLSearchParams(window.location.search).get('role'));
    }
  });

  searchInput.addEventListener('change', function () {
    if (!this.value.trim()) {
      updateURL('', new URLSearchParams(window.location.search).get('role'));
    }
  });
});