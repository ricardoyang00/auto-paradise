<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');

    $id = $_GET['id'];
    $db = getDatabaseConnection();
    $product = Product::getProductById($db, $id);
    $seller = User::getUserByUsername($db, $product->sellerId);
    $category = Category::getCategoryById($db, $product->category);
    $brand = Brand::getBrandById($db, $product->brandId);
    $scale = Scale::getScaleById($db, $product->scale);

    drawHeader();
?>

<section id="item">
    <div class="container">
        <div class="image">
            <?php $url = "item.php?id=" . $product->id; ?>
            <img src=<?="../database/images/originals/". $product->getProductThumbnail($db);?> alt="Product Image">
        </div>
        <div class="title">
            <section id="tags">
                <h2><?= $category->name ?></h2>
                <h2><?= $scale->name ?></h2>
                <h2><?= $brand->name ?></h2>
            </section>
            <h1><?= $product->title ?></h1>
            <h3>€<?= $product->price ?></h3>
            <button class="buy">Buy Now</button>
            <button class="add-wishlist"><a href="#"><i class="fa-regular fa-heart"></i></a></button> 
        </div>
        <div class="seller-info">
            <h2>Seller Information</h2>
            <p class="user-name"><i class="fa-solid fa-user"></i><?= $seller->name ?></p>
            <p class="location"><i class="fa-solid fa-location-dot"></i><?=$seller->getUserAddress($db)->city?>, <?=$seller->getUserAddress($db)->country?></p>
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
