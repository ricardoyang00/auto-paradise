<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');
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

    drawProductList($db, $products, $searchQuery ?? null);

?>
</section>

<?php drawFooter(); ?>