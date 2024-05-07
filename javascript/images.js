document.addEventListener('DOMContentLoaded', function() {
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const images = document.querySelectorAll('.carousel-image');
    let currentIndex = 0;

    function showImage(index) {
        images.forEach((image, idx) => {
            if (idx === index) {
                image.style.display = 'block';
            } else {
                image.style.display = 'none';
            }
        });
    }

    prevBtn.addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
        showImage(currentIndex);
    });

    nextBtn.addEventListener('click', function() {
        currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
        showImage(currentIndex);
    });

    showImage(currentIndex);
});

function changeImage(imgElement, newImageUrl) {
    if (newImageUrl) {
        imgElement.src = newImageUrl;
    }
}

function resetImage(imgElement, originalImageUrl) {
    imgElement.src = originalImageUrl;
}

document.getElementById('image').addEventListener('change', function(event) {
    var input = event.target;
    var preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    var maxFiles = 10; 
    var files = input.files;

    if (files.length > maxFiles) {
        alert('You can only upload a maximum of ' + maxFiles + ' files.');
        input.value = '';
        return;
    }

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();
        
        reader.onload = function(event) {
            var img = document.createElement('img');
            img.setAttribute('src', event.target.result);
            img.setAttribute('alt', 'Image Preview');
            img.style.maxWidth = '200px';
            preview.appendChild(img);
        }
        
        reader.readAsDataURL(file);
    }
});


document.getElementById('image').addEventListener('change', previewImages);