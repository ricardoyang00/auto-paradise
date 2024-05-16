document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-query');
    const searchNameInput = document.getElementById('search-name');
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

    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search');

    if (searchQuery && isSearchPage()) {
        searchNameInput.value = searchQuery;
        updateContent(searchQuery);
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(function() {
            const searchQuery = searchInput.value.trim();

            if (!isSearchPage()) {
                window.location.href = '../pages/search.php?search=' + encodeURIComponent(searchQuery);
            } else {
                searchNameInput.value = searchQuery;
                if (searchQuery !== '') {
                    updateContent(searchQuery);
                }
            }
        }, typingDelay);
    });
});