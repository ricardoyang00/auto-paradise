<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');

    $db = getDatabaseConnection();

?>

<?php

function drawProductList($db, $products, $searchQuery) {
    if (!empty($products)) {
        foreach ($products as $product) {?>
        <article>
            <?php 
                $url = "item.php?id=" . $product->id; 
                $product_images = $product->getProductImages($db);
                $product_thumb_url = "../database/images/" . $product->getProductThumbnail($db);
                $second_product_thumb_url = isset($product_images[1]) ? "../database/images/" . $product_images[1] : null;
            ?>
            <img src="<?= $product_thumb_url ?>" alt="<?= $product->title ?>"
                onmouseover="changeImage(this, '<?= $second_product_thumb_url ?>')"
                onmouseout="resetImage(this, '<?= $product_thumb_url ?>')">
            <a href="<?= $url ?>">
                <h1><?= $product->title ?></h1>
            </a>
            <a class="price"><p>€<?= $product->price ?></p></a>
            <?php $product_id = $product->id; ?>
            <?php $product_id = $product->id; ?>
            <button class="add-wishlist" onclick="addToWishlist(<?= $product_id ?>)">Add to Wishlist</button>
        </article>
        <?php } ?>
    <?php } 
    else { ?>
        <section id="no-results">
            <h1>No results for "<?php echo htmlspecialchars($searchQuery); ?>"</h1>
            <li>Check the spelling</li>
            <li>Try different keywords</li>
        </section>
    <?php } 
}?>