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
        <?php $url = "item.php?id=" . $product->id; ?>
        <img src="../images/products/<?= $product->id ?>.jpg" alt="<?= $product->title ?>">
        <a href="<?= $url ?>"><h1><?= $product->title ?></h1></a>
        <a class="price"><p>€<?= $product->price ?></p></a>
        <button class="add-wishlist">Add to Wishlist</button>
    </article>
<?php } ?>
