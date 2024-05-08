document.addEventListener("DOMContentLoaded", function() {
    var navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            var contentId = link.getAttribute('data-content');

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

