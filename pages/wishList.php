<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../utils/session.php');

    $session = new Session();
    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }

    $username = $session->getUsername();
    $db = getDatabaseConnection();
    $wishList = Product::getUserWishList($db, $username);

    drawHeader();
?>

<section id="wish-list">
  <h2>wishlist</h2>
    <?php foreach ($wishList as $product) { ?>
    <article>
        <img src="../database/images/<?= $product->getProductThumbnail($db) ?>">
        <div id="product-information">
            <h1><?= $product->title ?></h1>
            <p><?= $product->description ?></p>
            
        </div>
        <div id="product-price-buy">
            <p>€ <?= $product->price ?></p>
            <div id="actions">
                <button class="remove-wishlist" onclick="removeFromWishlist(<?= $product->id ?>)">
                    <i class="fa-solid fa-x"></i> Remove
                </button>
                <button class="buy" data-id="product-id">Buy <i class="fa-solid fa-cart-shopping"></i></button>
            </div>
        </div>
    </article>
    <?php } ?>
</section>

<?php drawFooter(); ?>