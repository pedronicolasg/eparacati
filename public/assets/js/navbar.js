const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const menuIcon = document.getElementById('menu-icon');
const closeIcon = document.getElementById('close-icon');

const userMenuButton = document.getElementById('user-menu-button');
const userDropdown = document.getElementById('user-dropdown');

function toggleMenu(menu, isInitialToggle = false) {
  const isHidden = menu.classList.contains('hidden');

  if (isHidden) {
    menu.classList.remove('hidden');
    menu.classList.add('transition-all', 'duration-300', 'ease-in-out');
    menu.classList.add('opacity-0', 'translate-y-[-10px]');

    void menu.offsetWidth;

    menu.classList.remove('opacity-0', 'translate-y-[-10px]');
  } else {
    menu.classList.add('opacity-0', 'translate-y-[-10px]');

    setTimeout(() => {
      menu.classList.add('hidden');
      menu.classList.remove('opacity-0', 'translate-y-[-10px]');
    }, 300);
  }
}

mobileMenuButton.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
  menuIcon.classList.toggle('hidden');
  closeIcon.classList.toggle('hidden');
});

userMenuButton.addEventListener('click', () => {
  toggleMenu(userDropdown);
});

document.addEventListener('click', (event) => {
  if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
    if (!mobileMenu.classList.contains('hidden')) {
      mobileMenu.classList.add('hidden');
      menuIcon.classList.remove('hidden');
      closeIcon.classList.add('hidden');
    }
  }

  if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
    if (!userDropdown.classList.contains('hidden')) {
      toggleMenu(userDropdown);
    }
  }
});