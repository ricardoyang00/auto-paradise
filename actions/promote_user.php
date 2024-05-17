<?php
    declare(strict_types = 1);
    
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/notification.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit();
    }

    if (!isset($_POST['userId'])) {
        http_response_code(400);
        exit();
    }

    $userId = $_POST['userId'];

    if (User::promoteUser($db, $userId)) {
        Notification::addNotification($db, $userId, "Promotion");
        echo json_encode(["status" => "SUCCESS"]);
    } else {
        echo json_encode(["status" => "ERROR"]);
    }
?>