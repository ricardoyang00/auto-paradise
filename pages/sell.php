<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/sell.tpl.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/scale.class.php');

    $db = getDatabaseConnection();
    
    $categories = Category::getAllCategories($db);
    $brands = Brand::getAllBrands($db);
    $scales = Scale::getAllScales($db);
    
    $scripts = [];
    drawHeader(true, $scripts, false);
    drawSellForm($session, $categories, $brands, $scales);
    drawFooter();
?>
