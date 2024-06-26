<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header("Location: ../pages/login.php");
        exit();
    }
    
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $dbh = getDatabaseConnection();
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $session->getCsrfToken()) {
            $session->addMessage('error', 'CSRF token mismatch.');
            header('Location: ../pages/index.php');
            exit();
        }

        $sellerId = $session->getUsername();
        $productId = Product::addProduct($dbh, $_POST['category'], $_POST['title'], $_POST['description'], $_POST['price'], $sellerId, $_POST['brand'], $_POST['scale']);
        
        if (isset($_FILES['image']) && is_array($_FILES['image']['tmp_name'])) {
            foreach ($_FILES['image']['tmp_name'] as $index => $tempFileName) {
                if ($tempFileName && $_FILES['image']['error'][$index] === UPLOAD_ERR_OK) {
                    $original = @imagecreatefromjpeg($tempFileName);
                    if (!$original) $original = @imagecreatefrompng($tempFileName);
                    if (!$original) $original = @imagecreatefromgif($tempFileName);
                    if (!$original) die('Unknown image format!');

                    $originalFileName = uniqid('image_') . '.jpg';
                    $uploadDir = '../database/images/';
                    imagejpeg($original, $uploadDir . $originalFileName);
                    imagedestroy($original);

                    Product::addProductImage($dbh, $productId, $originalFileName);
                } else {
                    die('Error uploading image.');
                }
            }
        } else {
            die('No image uploaded.');
        }

        if (Product::addProductState($dbh, (int)$productId, 'Available')) {
            $session->addMessage('success', 'Product uploaded successfully.');
        } else {
            $session->addMessage('error', 'Failed to upload product.');
        }

        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "Invalid request.";
    }
?>
