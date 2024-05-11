<?php
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/product.class.php');
require_once(__DIR__ . '/../../templates/products.tpl.php');

$db = getDatabaseConnection();

$searchQuery = isset($_GET['search']) ? $_GET['search'] : null;

if ($searchQuery) {
    $products = Product::getProductsByName($db, $searchQuery);
} else {
    $products = Product::getAllProducts($db);
}

drawProductList($db, $products, $searchQuery ?? null);

?>