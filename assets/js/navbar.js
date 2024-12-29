document.addEventListener('DOMContentLoaded', () => {
  const userMenuButton = document.getElementById('user-menu-button');
  const userDropdown = document.getElementById('user-dropdown');

  userMenuButton.addEventListener('click', (e) => {
    e.stopPropagation();
    userDropdown.classList.toggle('hidden');
  });

  document.addEventListener('click', () => {
    if (!userDropdown.classList.contains('hidden')) {
      userDropdown.classList.add('hidden');
    }
  });
});

const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.classList.add(savedTheme);

function toggleTheme() {
  const currentTheme = document.documentElement.classList.contains('light') ? 'light' : 'dark';
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';
  document.documentElement.classList.replace(currentTheme, newTheme);
  localStorage.setItem('theme', newTheme);
}