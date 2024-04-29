document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    filterForm.addEventListener('change', function() {
        const formData = new FormData(filterForm);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../pages/filter.php');
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('products').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed. Status:', xhr.status);
            }
        };
        xhr.send(formData);
    });
});

