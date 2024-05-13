<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/notifications.tpl.php');
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
    $notifications = Notification::getUserNotifications($db, $username);

    drawHeader(false);
    drawNotifications($db, $notifications);
    drawFooter();
?>


