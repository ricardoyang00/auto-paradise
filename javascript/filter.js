document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filter-form');

    function handleCheckboxSelection(selectedCategory) {
        if (selectedCategory === 'all') {
            const checkboxes = filterForm.querySelectorAll('input[name="category[]"]');
            checkboxes.forEach(function(checkbox) {
                const categoryId = parseInt(checkbox.value);
                if (categoryId !== 2 && categoryId !== 3 && categoryId !== 6) {
                    checkbox.checked = true;
                }
            });
        } else {
            const categoryCheckbox = document.querySelector(`input[name="category[]"][value="${selectedCategory}"]`);
            if (categoryCheckbox) {
                categoryCheckbox.checked = true;
            }
        }
    }

    function handleFormChange() {
        const formData = new FormData(filterForm);
        
        const formDataObject = {};
        formData.forEach(function(value, key){
            formDataObject[key] = value;
        });
        
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
    }

    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get('category');

    if (selectedCategory) {
        handleCheckboxSelection(selectedCategory);
        handleFormChange();
    }
    
    filterForm.addEventListener('change', handleFormChange);
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('search-query').addEventListener('input', function() {
        const searchQuery = this.value.trim();
        console.log("search query is " + searchQuery);

        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../pages/filter.php?search=' + encodeURIComponent(searchQuery)); 
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('products').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed. Status:', xhr.status);
            }
        };
        xhr.onerror = function() {
            console.error('Request failed');
        };
        xhr.send();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-query');
    let typingTimer;
    const typingDelay = 750;

    function updateContent(searchQuery) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../pages/content/search_content.php?search=' + encodeURIComponent(searchQuery));
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('products').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed. Status:', xhr.status);
            }
        };
        xhr.send();
    }

    function isSearchPage() {
        return window.location.pathname.includes('search.php');
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(function() {
            const searchQuery = searchInput.value.trim();

            if (!isSearchPage()) {
                window.location.href = '../pages/search.php?search=' + encodeURIComponent(searchQuery);
            } else {
                if (searchQuery !== '') {
                    updateContent(searchQuery);
                }
            }
        }, typingDelay);
    });
});
