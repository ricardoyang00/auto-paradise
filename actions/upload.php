<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../utils/session.php');

  $dbh = getDatabaseConnection();
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $session = new Session();
  if (!$session->isLoggedIn()) {
    header("Location: ../pages/login.php");
    exit();
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert product data into the database
    $sellerId = $session->getUsername();
    $stmt = $dbh->prepare('INSERT INTO PRODUCT (category, title, description, price, seller_id, brand, scale) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $_POST['category'],
        $_POST['title'],
        $_POST['description'],
        $_POST['price'],
        $sellerId,
        $_POST['brand'],
        $_POST['scale']
    ]);

    // Get the ID of the inserted product
    $productId = $dbh->lastInsertId();

    // Handle image upload for each file
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

                // Insert image details into the database
                $stmt = $dbh->prepare("INSERT INTO PRODUCT_IMAGES (product_id, image_url) VALUES (?, ?)");
                $stmt->execute([$productId, $originalFileName]);
            } else {
                die('Error uploading image.');
            }
        }
    } else {
        die('No image uploaded.');
    }

    header("Location: ../pages/index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
  