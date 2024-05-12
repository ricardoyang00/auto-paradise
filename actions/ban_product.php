<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/product.class.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit();
}

if (!isset($_POST['productId']) || !isset($_POST['banReason'])) {
    http_response_code(400);
    exit();
}

$db = getDatabaseConnection();

$productId = $_POST['productId'];
$banReason = $_POST['banReason'];


if (Product::banProduct($db, $productId, $banReason)) {
    echo "SUCCESS";
}
