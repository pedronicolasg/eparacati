function filterGrade(grade) {
  const url = new URL(window.location.href);

  if (grade) {
    url.searchParams.set('grade', grade);
  } else {
    url.searchParams.delete('grade');
  }

  window.location.href = url.toString();
}

function toggleDropdown() {
  const dropdown = document.getElementById("dropdownRadio");
  dropdown.classList.toggle("hidden");
}

function filterClasses(grade) {
  const url = new URL(window.location.href);
  url.searchParams.set('grade', grade);
  window.location.href = url;
}