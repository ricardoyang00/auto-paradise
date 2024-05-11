<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/category.class.php');
require_once(__DIR__ . '/../database/brand.class.php');
require_once(__DIR__ . '/../database/scale.class.php');

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
    case 'deleteBrand':
        if (!isset($_POST['brandId'])) {
            http_response_code(400);
            exit();
        }
        $brandId = $_POST['brandId'];
        if (Brand::deleteBrand($db, $brandId)) {
            echo "SUCCESS";
        }
        break;

    case 'addBrand':
        if (!isset($_POST['brandName'])) {
            http_response_code(400);
            exit();
        }
        $brandName = $_POST['brandName'];
        if (Brand::addBrand($db, $brandName)) {
            echo "SUCCESS";
        }
        break;

    case 'renameBrand':
        if (!isset($_POST['brandId']) || !isset($_POST['brandName'])) {
            http_response_code(400);
            exit();
        }
        $brandId = $_POST['brandId'];
        $brandName = $_POST['brandName'];
        if (Brand::renameBrand($db, $brandId, $brandName)) {
            echo "SUCCESS";
        }
        break;

    case 'deleteScale':
        if (!isset($_POST['scaleId'])) {
            http_response_code(400);
            exit();
        }
        $scaleId = $_POST['scaleId'];
        if (Scale::deleteScale($db, $scaleId)) {
            echo "SUCCESS";
        }
        break;

    case 'addScale':
        if (!isset($_POST['scaleName'])) {
            http_response_code(400);
            exit();
        }
        $scaleName = $_POST['scaleName'];
        if (Scale::addScale($db, $scaleName)) {
            echo "SUCCESS";
        }
        break;

    case 'renameScale':
        if (!isset($_POST['scaleId']) || !isset($_POST['scaleName'])) {
            http_response_code(400);
            exit();
        }
        $scaleId = $_POST['scaleId'];
        $scaleName = $_POST['scaleName'];
        if (Scale::renameScale($db, $scaleId, $scaleName)) {
            echo "SUCCESS";
        }
        break;
    default:
        http_response_code(400);
        exit();
}
