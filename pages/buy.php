<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../templates/checkout.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();
    
    $user = User::getUserByUsername($db, $session->getUsername());
    $address = Address::getAddressById($db, $user->addressId);
    
    $productId = $_GET['product_id'];
    $product = Product::getProductById($db, $productId);
    
    $scripts = ['checkout'];
    drawHeader(false, $scripts, false);
    drawMessages($session);

    if ($product->sellerId == $session->getUsername()) {
        $session->addMessage('error', 'You cannot buy your own product.');
        header('Location: /pages/index.php');
        exit();
    } else if (Product::getProductState($db, (int)$productId) == 'Sold') {
        $session->addMessage('error', 'This product has already been sold.');
        header('Location: /pages/index.php');
        exit();
    } else if (Product::isBanned($db, (int)$productId)) {
        $session->addMessage('error', 'This product has been banned.');
        header('Location: /pages/index.php');
        exit();
    } else {
        drawCheckoutPage($db, $user, $address, $product);
    }

    drawFooter();
?>