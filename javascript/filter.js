document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');
    const searchInput = document.querySelector('input[name="search"]');
    console.log("value is \"" + searchInput.value + "\"");

    
    filterForm.addEventListener('change', function() {
        const formData = new FormData(filterForm);
        const searchValue = searchInput.value.trim(); // Trim whitespace from search query
        formData.set('search', searchValue); // Add search query to form data
        console.log(formData.get('search'));
        
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
