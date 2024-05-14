<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }
    
    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');

    $db = getDatabaseConnection();
    
    $wishList = Product::getUserWishList($db, $session->getUsername());

    $scripts = [];
    drawHeader(true, $scripts, false);
    drawWishList($db, $wishList);
    drawFooter(); 
?>