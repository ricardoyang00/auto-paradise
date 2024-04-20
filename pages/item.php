<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $id = $_GET['id'];
    $db = getDatabaseConnection();
    $product = Product::getProductById($db, $id);
    $seller = User::getUserByUsername($db, $product->sellerId);

    drawHeader();
?>

<section id="item">
    <div class="container">
        <div class="image">
            <img src="../images/products/<?=$product->id?>.jpg" alt="Product Image">
        </div>
        <div class="title">
            <section id="tags">
                <h2><?= $product->getCategory($db) ?></h2>
                <h2><?= $product->getScale($db) ?></h2>
                <h2><?= $product->getBrand($db) ?></h2>
            </section>
            <h1><?= $product->title ?></h1>
            <h3>€<?= $product->price ?></h3>
            <button class="but">Buy Now</button>
            <button class="add-wishlist"><a href="#"><i class="fa-regular fa-heart"></i></a></button> 
        </div>
        <div class="seller-info">
            <h2>Seller Information</h2>
            <p class="name"><?= $seller->name ?></p>
            <p class="location"><i class="fa-solid fa-location-dot"></i>
                <?=$seller->getUserAddress($db)->city?>, <?=$seller->getUserAddress($db)->country?>
            </p>
        </div>
        <div class="description">
            <h2>Description</h2>
            <p><?= $product->description ?></p>
        </div>
        <div class="qna">
            <h2>Q&A</h2>
            <form>
                <textarea placeholder="Ask a question..."></textarea>
                <button type="submit">Submit</button>
            </form>
            <div class="qa-item">
                <p><strong>Q:</strong> Question text?</p>
                <p><strong>A:</strong> Answer text...</p>
            </div>
            <div class="qa-item">
                <p><strong>Q:</strong> Question text?</p>
                <p><strong>A:</strong> Answer text...</p>
            </div>
            <div class="qa-item">
                <p><strong>Q:</strong> Question text?</p>
                <p><strong>A:</strong> Answer text...</p>
            </div>
        </div>
    </div>
</section>


<?php drawFooter(); ?>
