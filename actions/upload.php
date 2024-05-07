<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../utils/session.php');

  // Database connection
  $dbh = getDatabaseConnection();
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $session = new Session();
  if (!$session->isLoggedIn()) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../pages/login.php");
    exit();
  }

  // Create folders if they don't exist
  if (!is_dir('../database/images')) mkdir('../database/images');
  if (!is_dir('../database/images/originals')) mkdir('../database/images/originals');
  if (!is_dir('../database/images/thumbs_small')) mkdir('../database/images/thumbs_small');
  if (!is_dir('../database/images/thumbs_medium')) mkdir('../database/images/thumbs_medium');
  

  // Check if the form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PHP saves the file temporarily here
    // 'image' is the name of the file input in the form
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      die('Error uploading image.');
    }
  
    // Check if 'image' key exists
    if (!array_key_exists('image', $_FILES)) {
        die('No image uploaded.');
    }
    $tempFileName = $_FILES['image']['tmp_name'];

    // Create an image representation of the original image
    // @ before function is to prevent warning messages
    $original = @imagecreatefromjpeg($tempFileName);
    if (!$original) $original = @imagecreatefrompng($tempFileName);
    if (!$original) $original = @imagecreatefromgif($tempFileName);

    if (!$original) die('Unknown image format!');

    // Generate filenames for original, small, and medium files
    $originalFileName = uniqid('image_') . '.jpg';
    $smallFileName = uniqid('image_') . '.jpg';
    $mediumFileName = uniqid('image_') . '.jpg';

    // Save original file as jpeg (even if it came in a different format)
    $uploadDir = '../database/images/originals/';
    imagejpeg($original, $uploadDir . $originalFileName);

    // Create and save a small square thumbnail
    $small = imagecreatetruecolor(200, 200);
    $square = min(imagesx($original), imagesy($original));
    imagecopyresized($small, $original, 0, 0, 0, 0, 200, 200, $square, $square);
    $thumbSmallDir = '../database/images/thumbs_small/';
    imagejpeg($small, $thumbSmallDir . $smallFileName);

    // Calculate width and height of medium-sized image (max width: 400)
    $mediumWidth = imagesx($original);
    $mediumHeight = imagesy($original);
    if ($mediumWidth > 400) {
        $mediumWidth = 400;
        $mediumHeight = (int) round($mediumHeight * ($mediumWidth / imagesx($original)));
    }

    // Create and save a medium image
    $medium = imagecreatetruecolor($mediumWidth, $mediumHeight);
    imagecopyresized($medium, $original, 0, 0, 0, 0, $mediumWidth, $mediumHeight, imagesx($original), imagesy($original));
    $thumbMediumDir = '../database/images/thumbs_medium/';
    imagejpeg($medium, $thumbMediumDir . $mediumFileName);


    // Get seller_id from session
    $sellerId = $session->getUsername();

    $stmt = $dbh->prepare('INSERT INTO PRODUCT (product_id, category, title, description, price, seller_id, brand, scale) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $productId,
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
  

    // Insert image details into the database
    $stmt = $dbh->prepare("INSERT INTO PRODUCT_IMAGES (product_id, image_url) VALUES (?, ?)");
    $stmt->execute([$productId, $originalFileName]);

    // Redirect to index.php after successful upload
    header("Location: ../pages/index.php");
    exit();
  } else {
    echo "Invalid request.";
  }
?>
  