<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    drawHeader();

    $db = getDatabaseConnection();
    $scales = Scale::getAllScales($db);
    $categories = Category::getAllCategories($db);
    $brands = Brand::getAllBrands($db);
?>

<aside id="filter">
    <h1>Filter by</h1>
    <form id="filter-form" action="#" method="get">
        <div class="filter-scale">
            <h2>Scale</h2>
            <ul>
                <?php foreach($scales as $scale){ ?>
                    <li><input type="checkbox" id="scale_<?= $scale->id ?>" name="scale[]" value="<?= $scale->id ?>"><label for="scale_<?= $scale->id ?>"><?= $scale->name ?></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-category">
            <h2>Category</h2>
            <ul>
                <?php foreach($categories as $category){ ?>
                    <li><input type="checkbox" id="category_<?= $category->id ?>" name="category[]" value="<?= $category->id ?>"><label for="category_<?= $category->id ?>"><?= $category->name ?></label></li>
                <?php } ?>
            </ul>
        </div>
        <div class="filter-brand">
            <h2>Brand</h2>
            <ul>
                <?php foreach($brands as $brand){ ?>
                    <li><input type="checkbox" id="brand_<?= $brand->id ?>" name="brand[]" value="<?= $brand->id ?>"><label for="brand_<?= $brand->id ?>"><?= $brand->name ?></label></li>
                <?php } ?>
            </ul>
        </div>
    </form>
</aside> 

<section id="products">
<?php
    if(isset($_GET['search']) && !empty($_GET['search'])) {
        $searchQuery = $_GET['search'];
        $products = Product::getProductsByName($db, $searchQuery);
    } else {
        $products = Product::getAllProducts($db);
    }

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
    <?php } else { ?>
        <section id="no-results">
            <h1>No results for "<?php echo htmlspecialchars($searchQuery); ?>"</h1>
            <li>Check the spelling</li>
            <li>Try different keywords</li>
        </section>
    <?php } ?>
</section>

<?php drawFooter(); ?>