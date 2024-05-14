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

document.addEventListener('DOMContentLoaded', function() {
    var replyButtons = document.querySelectorAll('.reply-notification');

    replyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var notificationId = button.getAttribute('data-notification-id');
            fetchQuestionAndProduct(notificationId);
        });
    });

    function fetchQuestionAndProduct(notificationId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../actions/fetch_question_product.php?id=' + notificationId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        console.log('Parsed JSON data:', data);
                        populatePopup(data);
                        document.getElementById('popup-reply').style.display = 'block';
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        console.log('Raw response text:', xhr.responseText);                    
                    }
                } else {
                    console.error('XHR request failed with status:', xhr.status);
                }
            }
        };
        xhr.send();
    }

    function populatePopup(data) {
        document.getElementById('product-image').src = "../database/images/" + data.product.image;
        document.getElementById('product-title').innerText = data.product.title;
        document.getElementById('question-content').innerText = data.question.question;
        document.getElementById('submit-reply').setAttribute('data-question-id', data.question.id);
        document.getElementById('notification-id').innerText = data.notification.id;
    }

    document.querySelector('.close-popup').addEventListener('click', function() {
        document.getElementById('popup-reply').style.display = 'none';
    });

    document.getElementById('submit-reply').addEventListener('click', function() {
        var replyText = document.getElementById('reply-text').value;
        var questionId = this.getAttribute('data-question-id');
        var notificationId = document.getElementById('notification-id').innerText;
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_reply.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log('Parsed JSON data:', response);
                if (response.success) {
                    document.getElementById('popup-reply').style.display = 'none';
                    location.reload();
                } else {
                    console.error('Reply submission failed:', response.error);
                    console.log('Raw response text:', xhr.responseText);
                }
            }
        };
        var params = 'reply=' + encodeURIComponent(replyText) + '&question_id=' + encodeURIComponent(questionId) + '&notification_id=' + encodeURIComponent(notificationId);
        xhr.send(params);
    });

    document.getElementById('dismiss-question').addEventListener('click', function() {
        var questionId = this.getAttribute('data-question-id');
        var notificationId = document.getElementById('notification-id').innerText;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../actions/action_dismiss_question.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log('Parsed JSON data:', response);
                if (response.success) {
                    document.getElementById('popup-reply').style.display = 'none';
                    location.reload();
                } else {
                    console.error('Reply submission failed:', response.error);
                    console.log('Raw response text:', xhr.responseText);
                }
            }
        };
        var params = '&question_id=' + encodeURIComponent(questionId) + '&notification_id=' + encodeURIComponent(notificationId);
        xhr.send(params);
    });
});



