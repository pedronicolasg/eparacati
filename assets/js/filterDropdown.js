function filterRole(role) {
  const url = new URL(window.location.href);

  if (role) {
    url.searchParams.set('role', role);
  } else {
    url.searchParams.delete('role');
  }

  window.location.href = url.toString();
}

function toggleDropdown() {
  const dropdown = document.getElementById("dropdownRadio");
  dropdown.classList.toggle("hidden");
}

function filterUsers(role) {
  const url = new URL(window.location.href);
  url.searchParams.set('role', role);
  window.location.href = url;
}