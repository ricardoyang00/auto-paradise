<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit();
}

if (!isset($_POST['action'])) {
    http_response_code(400);
    exit();
}

$db = getDatabaseConnection();

$action = $_POST['action'];

switch ($action) {
    case 'deleteCategory':
        if (!isset($_POST['categoryId'])) {
            http_response_code(400);
            exit();
        }
        $categoryId = $_POST['categoryId'];
        if (Category::deleteCategory($db, $categoryId)) {
            echo "SUCCESS";
        }
        break;

    case 'addCategory':
        if (!isset($_POST['categoryName'])) {
            http_response_code(400);
            exit();
        }
        $categoryName = $_POST['categoryName'];
        if (Category::addCategory($db, $categoryName)) {
            echo "SUCCESS";
        } 

        break; 
    case 'renameCategory':
        if (!isset($_POST['categoryId']) || !isset($_POST['categoryName'])) {
            http_response_code(400);
            exit();
        }
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        if (Category::renameCategory($db, $categoryId, $categoryName)) {
            echo "SUCCESS";
        }
        break;
    default:
        http_response_code(400);
        exit();
}
