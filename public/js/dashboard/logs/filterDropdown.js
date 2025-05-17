function filterAction(action) {
  const url = new URL(window.location.href);

  if (action) {
    url.searchParams.set('action', action);
  } else {
    url.searchParams.delete('action');
  }

  window.location.href = url.toString();
}

function toggleDropdown() {
  const dropdown = document.getElementById("dropdownRadio");
  dropdown.classList.toggle("hidden");
}

function filterLogs(action) {
  const url = new URL(window.location.href);
  
  if (action) {
    url.searchParams.set('action', action);
  } else {
    url.searchParams.delete('action');
  }
  
  url.searchParams.set('page', 1);
  
  window.location.href = url;
}