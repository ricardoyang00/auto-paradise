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

document.addEventListener('DOMContentLoaded', function() {
    const readButtons = document.querySelectorAll('.read-notification');
    const unreadButtons = document.querySelectorAll('.unread-notification');

    readButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            markNotificationAsRead(notificationId);
        });
    });

    unreadButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            markNotificationAsUnread(notificationId);
        });
    });

    function markNotificationAsRead(notificationId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/notification_mark.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            } else {
                console.error('Failed to mark the notification as read.');
            }
        };
        xhr.onerror = function() {
            console.error('Request failed');
        };
        xhr.send(`action=read&notification_id=${notificationId}`);
    }

    function markNotificationAsUnread(notificationId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/notification_mark.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.reload();
            } else {
                console.error('Failed to mark the notification as unread.');
            }
        };
        xhr.onerror = function() {
            console.error('Request failed');
        };
        xhr.send(`action=unread&notification_id=${notificationId}`);
    }
});


