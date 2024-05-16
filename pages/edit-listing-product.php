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
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');

    $db = getDatabaseConnection();
    
    $categories = Category::getAllCategories($db);
    $brands = Brand::getAllBrands($db);
    $scales = Scale::getAllScales($db);

    $user = User::getUserByUsername($db, $session->getUsername());
    $address = Address::getAddressById($db, $user->addressId);

    $productId = $_GET['product_id'];
    $product = Product::getProductById($db, $productId);
    $productCategory = Category::getCategoryById($db, $product->category);
    $productBrand = Brand::getBrandById($db, $product->brandId);
    $productScale = Scale::getScaleById($db, $product->scale);
    
    $scripts = [];
    drawHeader(false, $scripts, false);
    drawEditProductForm($session, $db, $categories, $brands, $scales, $product, $productId, $productCategory, $productBrand, $productScale);
    drawFooter();
?>