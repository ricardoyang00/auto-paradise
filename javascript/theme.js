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

document.addEventListener("DOMContentLoaded", function() {
  var navLinks = document.querySelectorAll('.nav-link');

  navLinks.forEach(function(link) {
      link.addEventListener('click', function(event) {
          event.preventDefault();

          var contentId = link.getAttribute('data-content');

          // Remove 'selected' class from all links
          navLinks.forEach(function(navLink) {
              navLink.classList.remove('selected');
          });

          // Add 'selected' class to the clicked link
          link.classList.add('selected');

          fetch('content/' + contentId + '_content.php')
          .then(response => response.text())
          .then(data => {
              document.querySelector('.account-content').innerHTML = data;
          })
          .catch(error => {
              console.error('Error fetching content:', error);
          });
      });
  });
});

function removeMessage() {
  var articles = document.querySelectorAll('#messages article');
  articles.forEach(function(article) {
      setTimeout(function() {
          article.style.transition = 'opacity 1s';
          article.style.opacity = 0;
          setTimeout(function() {
              article.style.display = 'none';
          }, 1000);
      }, 4000);
  });
}

window.onload = removeMessage;