<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../templates/checkout.tpl.php');

    drawHeader2();

    $db = getDatabaseConnection();

    $user = User::getUserByUsername($db, $session->getUsername());
    $userAddress = Address::getAddressById($db, $user->addressId);
    
    $orderId = $_GET['order_id'];
    $order = Order::getOrderById($db, (int)$orderId);
    $seller = User::getUserByUsername($db, $order->sellerUsername);
    $sellerAddress = Address::getAddressById($db, $seller->addressId);
    $product = Product::getProductById($db, $order->productId);
    $category = Category::getCategoryById($db, $product->category);
    $brand = Brand::getBrandById($db, $product->brandId);
    $scale = Scale::getScaleById($db, $product->scale);

    drawReceipt($db, $order, $user, $seller, $userAddress, $sellerAddress, $product, $brand, $scale, $category);
    
    drawFooter();
?>