<?php declare(strict_types = 1); ?>

<?php 
function drawNotifications(PDO $db, $notifications) { 
?>
    <section id="notifications">
        <h2>Notifications</h2>
        <?php if (empty($notifications)): ?>
            <article>
                <p id="emptyContent">No notifications to show.</p>
            </article>
        <?php else: 
            foreach($notifications as $notification) { ?>
                <article <?= $notification->isRead ? "class=\"read\"" : ''; ?>>
                    <div id="notification-details">
                        <div id="notification-title"><?= htmlspecialchars($notification->title, ENT_QUOTES, 'UTF-8') ?></div>
                        <div id="notification-content"><?= htmlspecialchars($notification->message, ENT_QUOTES, 'UTF-8') ?></div>
                        <div id="notification-date"><?= $notification->date->format('d M Y, H:i'); ?></div>
                    </div>
                    <div id="notification-actions">
                        <?php 
                            if ($notification->type==='Sold' || $notification->type==='Ban' || $notification->type==='Unban' || $notification->type==='Promotion') {
                                if ($notification->isRead) { ?>
                                    <button class="unread-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Unread</button>
                                <?php } else { ?>
                                    <button class="read-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Read</button>
                                <?php }
                            } 
                            else if ($notification->type==='Question') {
                                if (!$notification->isRead) { ?>
                                    <button class="reply-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-solid fa-reply"></i> Reply</button>
                                <?php } else { ?>
                                    <button class="replied-notification"><i class="fa-regular fa-comment-dots"></i> Replied</button>
                                <?php }
                            }
                            else if ($notification->type==='Reply') { ?>
                                <button class="answer-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-regular fa-circle-question"></i> Details</button>
                            <?php } ?>
                    </div>
                </article>
            <?php } ?>
        <?php endif; ?>
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
                <textarea id="reply-text" placeholder="Your reply..." maxlength="100"></textarea>
                <button id="submit-reply">Submit Reply</button>
            </div>
            <button id="dismiss-question"><i class="fa-solid fa-trash"></i></button>
        </div>
    </div>

    <div id="popup-answer" class="popup-answer">
        <div id="answer-notification-id"></div>
        <div class="popup-content">
            <span class="answer-close-popup">&times;</span>
            <div id="product-details">
                <img id="answer-product-image" src="" alt="Product Image">
                <h3 id="answer-product-title"></h3>
            </div>
            <div id="question-details">
                <p id="answer-question-content"></p>
                <p id="answer-content"></p>
            </div>
            <button id="read-button"><i class="fa-brands fa-readme"></i> Read</button>
            <a href="" id="product-url" class="button"><i class="fa-solid fa-location-arrow"></i> Go to page</a>
        </div>
    </div>
<?php } ?>
