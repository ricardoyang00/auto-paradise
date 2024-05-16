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