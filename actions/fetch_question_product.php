<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/question.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../database/notification.class.php');

$db = getDatabaseConnection();

if (isset($_GET['id'])) {
    $notificationId = $_GET['id'];

    $notification = Notification::getNotificationById($db, $notificationId);

    if ($notification && $notification->extra_id !== null && $notification->type === 'Question') {
        $question = Questions::getQuestionById($db, $notification->extra_id);
        $product = Product::getProductById($db, $question->productId);
        if ($product) {
            $productImage = $product->getProductThumbnail($db);
            header('Content-Type: application/json');
            echo json_encode([
                'question' => [
                    'id' => $question->id,
                    'sender' => $question->sender,
                    'question' => $question->question,
                    'answer' => $question->answer,
                    'productId' => $question->productId
                ],
                'product' => [
                    'id' => $product->id,
                    'image' => $productImage,
                    'title' => $product->title
                ]
            ]);
            exit;
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
    } else {
        echo json_encode(['error' => 'Notification not found or not a question']);
    }
} else {
    echo json_encode(['error' => 'Notification ID not provided']);
}
?>
