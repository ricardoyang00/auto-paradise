function delayedRedirect(url, delay) {
    setTimeout(function() {
        window.location.href = url;
    }, delay);
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname.endsWith('waitPayment.php')) {
        delayedRedirect('../pages/account.php', 3000);
    }
});