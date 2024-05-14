<?php declare(strict_types = 1); ?>

<?php function drawNotifications(PDO $db, $notifications) { ?>
    <section id="notifications">
        <h2>Notifications</h2>
        <?php foreach($notifications as $notification) { ?>
            <article <?= $notification->isRead ? "class=\"read\"" : ''; ?>>
                <div id="notification-details">
                    <div id="notification-title"><?= htmlspecialchars($notification->title, ENT_QUOTES, 'UTF-8') ?></div>
                    <div id="notification-content"><?= htmlspecialchars($notification->message, ENT_QUOTES, 'UTF-8') ?></div>
                    <div id="notification-date"><?= $notification->date->format('d M Y, H:i'); ?></div>
                </div>
                <div id="notification-actions">
                    <?php if ($notification->type !== 'Question') {
                        if ($notification->isRead) { ?>
                            <button class="unread-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Unread</button>
                        <?php } else { ?>
                            <button class="read-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-brands fa-readme"></i> Read</button>
                        <?php }
                    } else if ($notification->type === 'Question') { ?>
                        <button class="reply-notification" data-notification-id="<?= $notification->id ?>"><i class="fa-solid fa-reply"></i> Reply</button>
                    <?php } ?>
                </div>
            </article>
        <?php } ?>
    </section>
<?php } ?>