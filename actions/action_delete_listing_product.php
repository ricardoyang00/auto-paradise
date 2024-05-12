<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    $db = getDatabaseConnection();
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        error_log("Product ID: " . $product_id);
        $product = Product::getProductById($db, (int)$product_id);

        if ($product->deleteProductById($db, (int)$product_id)) {
            $session->addMessage('success', 'Product removed successfully');
        } else {
            $session->addMessage('error', 'Failed to remove product');
        }
        exit();
    } else {
        exit();
    }
?>