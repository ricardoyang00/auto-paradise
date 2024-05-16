<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }
    
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');

    $db = getDatabaseConnection();

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        $product = Product::getProductById($db, $product_id);
        $product->removeFromWishlist($db, $session->getUsername());

        http_response_code(200);
        exit();
    } else {
        http_response_code(400);
        exit();
    }
?>