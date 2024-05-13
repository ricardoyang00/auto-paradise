<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/sell.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $db = getDatabaseConnection();
    $categories = Category::getAllCategories($db);
    $scales = Scale::getAllScales($db);
    $brands = Brand::getAllBrands($db);

    $section = new Session();
    if (!$section->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }
    
    drawHeader(true);
    drawSellForm($categories, $brands, $scales);
    drawFooter();
?>
