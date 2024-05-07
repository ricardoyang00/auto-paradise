const themeSelector = document.querySelector('body > header .user-actions .theme-selector');
const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)').matches;

const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light')
setTheme(currentTheme)

if (themeSelector) {
    themeSelector.addEventListener('click', toggleTheme);
}

function toggleTheme() {
  const currentTheme = localStorage.getItem('theme') || (prefersDarkScheme ? 'dark' : 'light')
  const otherTheme = currentTheme === 'light' ? 'dark' : 'light'
  localStorage.setItem('theme', otherTheme);
  setTheme(otherTheme);
}

function setTheme(theme) {
  document.documentElement.setAttribute('data-theme', theme);

  if (themeSelector) {
    themeSelector.classList.remove('fa-solid', 'fa-regular');
    themeSelector.classList.remove('fa-moon', 'fa-sun');
    themeSelector.classList.add(theme === 'light' ? 'fa-regular' : 'fa-solid');
    themeSelector.classList.add(theme === 'light' ? 'fa-sun' : 'fa-moon');
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const heartIcon = document.querySelector('.fa-heart');

  heartIcon.addEventListener('mouseenter', function() {
      heartIcon.classList.remove('fa-regular');
      heartIcon.classList.add('fa-solid');
      heartIcon.style.color = 'red';
  });

  heartIcon.addEventListener('mouseleave', function() {
      heartIcon.classList.remove('fa-solid');
      heartIcon.classList.add('fa-regular');
      heartIcon.style.color = '';
  });
});
