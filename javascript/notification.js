function removeMessage() {
    var articles = document.querySelectorAll('#messages article');
    articles.forEach(function(article) {
        setTimeout(function() {
            article.style.transition = 'opacity 1s';
            article.style.opacity = 0;
            setTimeout(function() {
                article.style.display = 'none';
            }, 1000);
        }, 4000);
    });
}

window.onload = removeMessage;
