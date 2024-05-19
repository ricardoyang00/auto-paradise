<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/notification.class.php');
    require_once(__DIR__ . '/../database/question.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $questionId = $_POST['question_id'];
        $notificationId = $_POST['notification_id'];

        Questions::deleteQuestion($db, $questionId);
        Notification::deleteNotification($db, $notificationId);

        echo json_encode(['success' => true]);
    } else {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    }   
?>