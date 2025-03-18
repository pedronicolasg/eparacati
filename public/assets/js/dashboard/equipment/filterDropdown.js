function filterRole(type) {
  const url = new URL(window.location.href);

  if (type) {
    url.searchParams.set('type', type);
  } else {
    url.searchParams.delete('type');
  }

  window.location.href = url.toString();
}

function toggleDropdown() {
  const dropdown = document.getElementById("dropdownRadio");
  dropdown.classList.toggle("hidden");
}

function filterEquipments(type) {
  const url = new URL(window.location.href);
  url.searchParams.set('type', type);
  window.location.href = url;
}