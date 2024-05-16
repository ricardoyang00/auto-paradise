<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $session->getCsrfToken()) {
            $session->addMessage('error', 'CSRF token mismatch.');
            header('Location: ../pages/index.php');
            exit();
        }

        $db = getDatabaseConnection();
        $product = Product::getProductById($db, (int)$_POST['product_id']);

        if (isset($_POST['title'])) {
            $product->title = $_POST['title'];
        }
        if (isset($_POST['description'])) {
            $product->description = $_POST['description'];
        }
        if (isset($_POST['category'])) {
            $product->category = (int)$_POST['category'];
        }
        if (isset($_POST['brand'])) {
            $product->brandId = (int)$_POST['brand'];
        }
        if (isset($_POST['scale'])) {
            $product->scale = (int)$_POST['scale'];
        }
        if (isset($_POST['price'])) {
            $product->price = (float)$_POST['price'];
        }

        $product->updateProduct($db);

        $session->addMessage('success', 'Product updated!');
        header('Location: ../pages/account.php');
    }
?>