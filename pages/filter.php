<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');

    $db = getDatabaseConnection();
    $filters = [];

    if(isset($_POST['scale']) && is_array($_POST['scale'])) {
        $filters['scale'] = $_POST['scale'];
    }
    if(isset($_POST['category']) && is_array($_POST['category'])) {
        $filters['category'] = $_POST['category'];
    }
    if(isset($_POST['brand']) && is_array($_POST['brand'])) {
        $filters['brand'] = $_POST['brand'];
    }

    $searchQuery = isset($_POST['search-name']) ? $_POST['search-name'] : null;

    $productsByName = Product::getProductsByName($db, $searchQuery);
    $filteredProducts = Product::getFilteredProducts($db, $filters);

    $intersectedProducts = [];
    foreach ($productsByName as $productByName) {
        foreach ($filteredProducts as $filteredProduct) {
            if ($productByName->id === $filteredProduct->id) {
                $intersectedProducts[] = $productByName;
                break;
            }
        }
    }

    $searchQuery = $searchQuery ?? '';
    drawProductList($db, $intersectedProducts, $searchQuery ?? null);
?>
