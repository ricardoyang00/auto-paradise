<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();
    
    $id = $_GET['id'];
    $product = Product::getProductById($db, $id);

    $isAdmin = false;
    if ($session->isLoggedIn()) {
        if (User::isAdmin($db, $session->getUsername())) {
            $isAdmin = true;
        }
    }

    $scripts = [];
    drawHeader(true, $scripts, false);
    drawProductItem($product, $isAdmin);
    drawFooter();
?>
