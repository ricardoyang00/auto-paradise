function attachEditIconEventListeners() {
    var editIcons = document.querySelectorAll('.edit-icon');

    editIcons.forEach(function(icon) {
        icon.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('../pages/content/edit_profile.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.account-content').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching content:', error);
            });
        });
    });
}

function attachChangePasswordIconEventListeners() {
    var editIcons = document.querySelectorAll('.change-password-icon');

    editIcons.forEach(function(icon) {
        icon.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('../pages/content/change_password.php')
            .then(response => response.text())
            .then(data => {
                document.querySelector('.account-content').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching content:', error);
            });
        });
    });
}

document.addEventListener("DOMContentLoaded", function() {
    attachEditIconEventListeners();
    attachChangePasswordIconEventListeners();
});

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
                if (contentId === "profile") {
                    attachEditIconEventListeners();
                    attachChangePasswordIconEventListeners();
                }
            })
            .catch(error => {
                console.error('Error fetching content:', error);
            });
        });
    });
});

function deleteListedProduct(productId) {
    document.getElementById('confirmationModal').style.display = 'block';

    function hideModal() {
        document.getElementById('confirmationModal').style.display = 'none';
    }

    document.getElementById('confirmDelete').onclick = function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../actions/action_delete_listing_product.php?product_id=' + encodeURIComponent(productId), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                hideModal();
                location.reload();
            }
        };
        xhr.send();
    };

    document.getElementById('cancelDelete').onclick = function() {
        hideModal();
    };
}