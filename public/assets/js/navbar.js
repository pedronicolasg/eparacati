const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const menuIcon = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');

mobileMenuButton.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
  menuIcon.classList.toggle('hidden');
  closeIcon.classList.toggle('hidden');
});

const userMenuButton = document.getElementById('user-menu-button');
const userDropdown = document.getElementById('user-dropdown');

userMenuButton.addEventListener('click', () => {
  userDropdown.classList.toggle('hidden');
});

document.addEventListener('click', (event) => {
  if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
    userDropdown.classList.add('hidden');
  }
});