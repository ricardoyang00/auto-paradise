<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/product.class.php');

$db = getDatabaseConnection();
$filters = array();

if(isset($_POST['scale']) && is_array($_POST['scale'])) {
    $filters['scale'] = $_POST['scale'];
}
if(isset($_POST['category']) && is_array($_POST['category'])) {
    $filters['category'] = $_POST['category'];
}
if(isset($_POST['brand']) && is_array($_POST['brand'])) {
    $filters['brand'] = $_POST['brand'];
}

$filteredProducts = Product::getFilteredProducts($db, $filters);

foreach ($filteredProducts as $product) { ?>
    <article>
        <?php 
            $url = "item.php?id=" . $product->id; 
            $product_images = $product->getProductImages($db);
            $product_thumb_url = "../database/images/" . $product_images[0];
            $second_product_thumb_url = isset($product_images[1]) ? "../database/images/" . $product_images[1] : null;
        ?>
        <img src="<?= $product_thumb_url ?>" alt="<?= $product->title ?>"
            onmouseover="changeImage(this, '<?= $second_product_thumb_url ?>')"
            onmouseout="resetImage(this, '<?= $product_thumb_url ?>')">
        <a href="<?= $url ?>">
            <h1><?= $product->title ?></h1>
        </a>
        <a class="price"><p>€<?= $product->price ?></p></a>
        <button class="add-wishlist">Add to Wishlist</button>
    </article>
<?php } ?>
