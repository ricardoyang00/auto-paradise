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

document.addEventListener('DOMContentLoaded', function submitSearch(event) {
    event.preventDefault();
    
    const searchForm = event.target; 
    const searchQuery = searchForm.querySelector('input[name="search"]').value.trim(); 
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
    xhr.send();
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
