<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/notification.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    $username = $session->getUsername();
    $db = getDatabaseConnection();
    $wishList = Product::getUserWishList($db, $username);
    $notifications = Notification::getUserNotifications($db, $username);

    drawHeader2();
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

<?php drawFooter(); ?>