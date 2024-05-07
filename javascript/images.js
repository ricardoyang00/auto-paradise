function changeImage(imgElement, newImageUrl) {
    if (newImageUrl) {
        imgElement.src = newImageUrl;
    }
}

function resetImage(imgElement, originalImageUrl) {
    imgElement.src = originalImageUrl;
}

function previewImages(event) {
    var preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    var files = event.target.files;
    
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
}

document.getElementById('image').addEventListener('change', previewImages);