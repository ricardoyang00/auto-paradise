<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../../pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/user.class.php');
    require_once(__DIR__ . '/../../database/category.class.php');
    require_once(__DIR__ . '/../../database/brand.class.php');
    require_once(__DIR__ . '/../../database/scale.class.php');
    require_once(__DIR__ . '/../../templates/admin.tpl.php');

    $db = getDatabaseConnection();
    
    $username = $session->getUsername();
    $user = User::getUserByUsername($db, $username);

    if (!User::isAdmin($db, $username)) {
        header('Location: ../../pages/account.php');
        exit();
    }

    $categories = Category::getAllCategories($db);
    $brands = Brand::getAllBrands($db);
    $scales = Scale::getAllScales($db);
    $bannedProducts = Product::getBannedProducts($db);
    
    drawAdminSection($categories, $brands, $scales, $bannedProducts);
?>