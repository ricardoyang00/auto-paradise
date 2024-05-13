<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/question.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../utils/session.php');

$session = new Session();
if (!$session->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array('error' => 'Unauthorized'));
    exit();
}

$sender = $session->getUsername();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['question']) && isset($_POST['productId'])) {
        $question = $_POST['question'];
        $productId = $_POST['productId'];
        
        $db = getDatabaseConnection();
        $productOwner = Product::getProductById($db, $productId)->sellerId;

        if ($productOwner === $sender) {
            http_response_code(403);
            echo json_encode(array('error' => 'You cannot ask questions about your own products.'));
            exit();
        }

        Questions::askQuestion($db, $productId, $sender, $question);
        exit();
    } else {
        http_response_code(400);
        echo json_encode(array('error' => 'Missing required parameters.'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method not allowed.'));
}
?>
