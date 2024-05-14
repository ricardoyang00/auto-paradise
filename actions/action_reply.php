<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/question.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../database/notification.class.php');
require_once(__DIR__ . '/../templates/notifications.tpl.php');

$db = getDatabaseConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $replyText = $_POST['reply'];
    $questionId = $_POST['question_id'];
    $notificationId = $_POST['notification_id'];

    $question = Questions::getQuestionById($db, $questionId);
    $question->answerQuestion($db, $replyText);

    Notification::markAsReaded($db, $notificationId);
    //Notification::addNotification($db, $question->sender, 'Reply', $questionId);

    echo json_encode(['success' => true]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}

?>