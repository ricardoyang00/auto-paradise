<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/product.class.php');

    require_once(__DIR__ . '/../utils/session.php');

    $id = $_GET['id'];
    $db = getDatabaseConnection();
    $product = Product::getProductById($db, $id);

    $session = new Session();
    $isAdmin = false;
    if ($session->isLoggedIn()) {
        if (User::isAdmin($db, $session->getUsername())) {
            $isAdmin = true;
        }
    }

    drawHeader(true);
    drawProductItem($product, $isAdmin);
    drawFooter();
?>
