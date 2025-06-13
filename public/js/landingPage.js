const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const menuIcon = document.getElementById('menu-icon');
const menuLogo = document.getElementById('menu-logo');
const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link');
let isMenuOpen = false;

function toggleMobileMenu() {
  isMenuOpen = !isMenuOpen;

  if (isMenuOpen) {
    mobileMenu.classList.remove('hidden');
    setTimeout(() => {
      mobileMenu.classList.remove('-translate-y-full', 'opacity-0');
      mobileMenu.classList.add('translate-y-0', 'opacity-100');
    }, 10);

    menuIcon.classList.add('hidden');
    menuLogo.classList.remove('hidden');

    document.body.style.overflow = 'hidden';
  } else {
    mobileMenu.classList.add('-translate-y-full', 'opacity-0');
    mobileMenu.classList.remove('translate-y-0', 'opacity-100');

    setTimeout(() => {
      mobileMenu.classList.add('hidden');
    }, 300);

    menuIcon.classList.remove('hidden');
    menuLogo.classList.add('hidden');

    document.body.style.overflow = '';
  }
}

if (mobileMenuButton) {
  mobileMenuButton.addEventListener('click', toggleMobileMenu);
}

mobileMenuLinks.forEach(link => {
  link.addEventListener('click', () => {
    if (isMenuOpen) {
      toggleMobileMenu();
    }
  });
});

document.addEventListener('click', (e) => {
  if (isMenuOpen &&
    !mobileMenu.contains(e.target) &&
    !mobileMenuButton.contains(e.target)) {
    toggleMobileMenu();
  }
});

function setupThemeToggle(buttonId) {
  const themeToggle = document.getElementById(buttonId);
  if (!themeToggle) return;

  themeToggle.addEventListener('click', () => {
    document.documentElement.classList.toggle('dark');
    const isDark = document.documentElement.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });
}

setupThemeToggle('theme-toggle');
setupThemeToggle('theme-toggle-mobile');

const savedTheme = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
  document.documentElement.classList.add('dark');
}

let swiper;

function initSwiper() {
  if (swiper) {
    swiper.destroy(true, true);
  }

  swiper = new Swiper('.hero-swiper', {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    effect: 'fade',
    fadeEffect: {
      crossFade: true
    },
    speed: 1000,
    allowTouchMove: true,
    grabCursor: true
  });
}

document.addEventListener('DOMContentLoaded', initSwiper);

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      const offsetTop = target.offsetTop - 80;
      window.scrollTo({
        top: offsetTop,
        behavior: 'smooth'
      });
    }
  });
});

const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate-slide-up');
    }
  });
}, observerOptions);

document.querySelectorAll('section').forEach(section => {
  observer.observe(section);
});

window.addEventListener('resize', () => {
  if (window.innerWidth >= 1024 && isMenuOpen) {
    toggleMobileMenu();
  }
});

let lastTouchEnd = 0;
document.addEventListener('touchend', function (event) {
  const now = (new Date()).getTime();
  if (now - lastTouchEnd <= 300) {
    event.preventDefault();
  }
  lastTouchEnd = now;
}, false);