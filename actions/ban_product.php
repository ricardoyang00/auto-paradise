<?php
    declare(strict_types=1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/notification.class.php');
    require_once(__DIR__ . '/../database/product.class.php');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit();
    }

    if (!isset($_POST['productId']) || !isset($_POST['banReason'])) {
        http_response_code(400);
        exit();
    }

    $db = getDatabaseConnection();
    $productId = $_POST['productId'];
    $product = Product::getProductById($db, $productId);
    $banReason = $_POST['banReason'];

    if (Product::isBanned($db, $productId)) {
        http_response_code(400);
        exit();
    }

    if (Product::banProduct($db, $productId, $banReason)) {
        Notification::addNotification($db, $product->sellerId, "Ban", $productId);
        echo "SUCCESS";
    } else {
        http_response_code(500);
    }
?>
