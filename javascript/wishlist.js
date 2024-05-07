function toggleHeartIcon() {
    var heartIcon = document.querySelector('.fa-heart');
    heartIcon.classList.remove('fa-regular');
    heartIcon.classList.add('fa-solid');
    heartIcon.style.color = 'red';

    setTimeout(function() {
        heartIcon.style.color = '';
        heartIcon.classList.remove('fa-solid');
        heartIcon.classList.add('fa-regular');
    }, 1000);
}

function addToWishlist(productId) {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '../actions/add_to_wishlist.php?product_id=' + encodeURIComponent(productId), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                //alert('Product added to wishlist.');

                for (var i = 0; i < 4; i++) {
                    setTimeout(toggleHeartIcon, i * 1800);
                }

            } else {
                //alert('Failed to add product to wishlist.');
            }
        }
    };

    xhr.send();
}

function removeFromWishlist(productId) {
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '../actions/remove_from_wishlist.php?product_id=' + encodeURIComponent(productId), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                //alert('Product removed from wishlist.');
                location.reload();
            } else {
                //alert('Failed to remove product from wishlist.');
            }
        }
    };

    xhr.send();
}

