<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/notification.class.php');

$db = getDatabaseConnection();

if (isset($_POST['notification_id']) && !empty($_POST['notification_id'])) {
    $notificationId = filter_var($_POST['notification_id'], FILTER_SANITIZE_NUMBER_INT);
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($action === 'read' || $action === 'unread') {
        if ($action === 'read') {
            Notification::markAsReaded($db, $notificationId);
        } elseif ($action === 'unread') {
            Notification::markAsUnreaded($db, $notificationId);
        }

        http_response_code(200);
        echo 'Notification status updated successfully.';
        exit;
    } else {
        http_response_code(400);
        echo 'Invalid action.';
        exit;
    }
} else {
    http_response_code(400);
    echo 'Notification ID is required.';
    exit;
}
?>
