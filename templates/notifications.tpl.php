<?php declare(strict_types = 1); ?>

<?php 
function drawNotifications(PDO $db, $notifications) { 
?>
    <section id="notifications">
        <h2>Notifications</h2>
        <?php foreach($notifications as $notification) { ?>
            <article <?= $notification->isRead ? "class=\"read\"" : ''; ?>>
                <div id="notification-details">
                    <div id="notification-title"><?= $notification->title; ?></div>
                    <div id="notification-content"><?= $notification->message; ?></div>
                    <div id="notification-date"><?= $notification->date->format('d M Y, H:i'); ?></div>
                </div>
                <div id="notification-actions">
                    <?php 
                        switch ($notification->type) {
                            case 'Sold':
                                if ($notification->isRead) { ?>
                                    <button class="unread-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Unread</button>
                                <?php } else { ?>
                                    <button class="read-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Read</button>
                                <?php }
                                break;
                            case 'Question':
                                if (!$notification->isRead) { ?>
                                    <button class="reply-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-solid fa-reply"></i> Reply</button>
                                <?php } else { ?>
                                    <button class="replied-notification"><i class="fa-regular fa-comment-dots"></i> Replied</button>
                                <?php }
                        }
                    ?>
                </div>
            </article>
        <?php } ?>
    </section>

    <div id="popup-reply" class="popup-reply">
        <div id="notification-id"></div>
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <div id="product-details">
                <img id="product-image" src="" alt="Product Image">
                <h3 id="product-title"></h3>
            </div>
            <div id="question-details">
                <p id="question-content"></p>
                <textarea id="reply-text" placeholder="Your reply..."></textarea>
                <button id="submit-reply">Submit Reply</button>
            </div>
            <button id="dismiss-question"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>
<?php } ?>
