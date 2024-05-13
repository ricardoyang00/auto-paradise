<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/products.tpl.php');
    require_once(__DIR__ . '/../templates/search.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    drawHeader(true);

    $db = getDatabaseConnection();
    $scales = Scale::getAllScales($db);
    $categories = Category::getAllCategories($db);
    $brands = Brand::getAllBrands($db);

    drawFilter($scales, $categories, $brands);
?>

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