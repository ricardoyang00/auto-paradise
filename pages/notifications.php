<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();
    
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }
    
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/notifications.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/notification.class.php');

    $db = getDatabaseConnection();

    $username = $session->getUsername();
    $notifications = Notification::getUserNotifications($db, $username);

    $scripts = ['notification'];
    drawHeader(false, $scripts, false);
    drawNotifications($db, $notifications);
    drawFooter();
?>


