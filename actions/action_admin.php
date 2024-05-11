<?php

declare(strict_types=1);

// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    exit();
}

// Check if the action parameter is provided in the request
if (!isset($_POST['action'])) {
    http_response_code(400); // Bad Request
    exit();
}

// Include necessary files
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/category.class.php');

// Get a database connection
$db = getDatabaseConnection();

// Handle different actions
$action = $_POST['action'];

switch ($action) {
    case 'deleteCategory':
        // Check if the category ID is provided
        if (!isset($_POST['categoryId'])) {
            http_response_code(400); // Bad Request
            exit();
        }
        $categoryId = $_POST['categoryId'];
        $result = Category::deleteCategory($db, $categoryId);
        if ($result) {
            echo "Category deleted successfully";
        } else {
            echo "Failed to delete category";
        }
        break;
    case 'addCategory':
        // Check if the category name is provided
        if (!isset($_POST['categoryName'])) {
            http_response_code(400); // Bad Request
            exit();
        }
        $categoryName = $_POST['categoryName'];
        $result = Category::addCategory($db, $categoryName);
        if ($result) {
            echo "Category added successfully";
        } else {
            echo "Failed to add category";
        }
        break;
    case 'renameCategory':
        // Check if the category ID and name are provided
        if (!isset($_POST['categoryId']) || !isset($_POST['categoryName'])) {
            http_response_code(400); // Bad Request
            exit();
        }
        $categoryId = $_POST['categoryId'];
        $categoryName = $_POST['categoryName'];
        $result = Category::renameCategory($db, $categoryId, $categoryName);
        if ($result) {
            echo "Category renamed successfully";
        } else {
            echo "Failed to rename category";
        }
        break;
    default:
        http_response_code(400); // Bad Request
        exit();
}
