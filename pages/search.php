<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../templates/common.tpl.php');
    drawHeader();
?>

<aside id="filter">
    <h1>Filter by</h1>
    <form id="filter-form" action="#" method="get">
        <div class="filter-option">
            <h2>Scale:</h2>
                <ul>
                    <li><input type="checkbox" id="scale_1_8" name="scale" value="1/8"><label for="scale_1_8">1/8</label></li>
                    <li><input type="checkbox" id="scale_1_12" name="scale" value="1/12"><label for="scale_1_12">1/12</label></li>
                    <li><input type="checkbox" id="scale_1_18" name="scale" value="1/18"><label for="scale_1_18">1/18</label></li>
                    <li><input type="checkbox" id="scale_1_24" name="scale" value="1/24"><label for="scale_1_24">1/24</label></li>
                    <li><input type="checkbox" id="scale_1_32" name="scale" value="1/32"><label for="scale_1_32">1/32</label></li>
                    <li><input type="checkbox" id="scale_1_43" name="scale" value="1/43"><label for="scale_1_43">1/43</label></li>
                    <li><input type="checkbox" id="scale_1_64" name="scale" value="1/64"><label for="scale_1_64">1/64</label></li>
                </ul>
            </div>
            <div class="filter-option">
                <h2>Category:</h2>
                <ul>
                    <li><input type="checkbox" id="category_civil_cars" name="category" value="civil_cars"><label for="category_civil_cars">Civil Cars</label></li>
                    <li><input type="checkbox" id="category_dtm" name="category" value="dtm"><label for="category_dtm">DTM</label></li>
                    <li><input type="checkbox" id="category_f1" name="category" value="f1"><label for="category_f1">F1</label></li>
                    <li><input type="checkbox" id="category_le_mans" name="category" value="le_mans"><label for="category_le_mans">Le Mans</label></li>
                    <li><input type="checkbox" id="category_rally" name="category" value="rally"><label for="category_rally">Rally</label></li>
                    <li><input type="checkbox" id="category_hotwheels" name="category" value="hotwheels"><label for="category_hotwheels">Hotwheels</label></li>
                    <li><input type="checkbox" id="category_other" name="category" value="other"><label for="category_other">Others</label></li>
                </ul>
            </div>
            <div class="filter-option">
                <h2>Brand:</h2>
                <ul>
                    <li><input type="checkbox" id="acura" name="brand" value="Acura"><label for="acura">Acura</label></li>
                    <li><input type="checkbox" id="alfa_romeo" name="brand" value="Alfa Romeo"><label for="alfa_romeo">Alfa Romeo</label></li>
                    <li><input type="checkbox" id="aston_martin" name="brand" value="Aston Martin"><label for="aston_martin">Aston Martin</label></li>
                    <li><input type="checkbox" id="audi" name="brand" value="Audi"><label for="audi">Audi</label></li>
                    <li><input type="checkbox" id="bentley" name="brand" value="Bentley"><label for="bentley">Bentley</label></li>
                    <li><input type="checkbox" id="bmw" name="brand" value="BMW"><label for="bmw">BMW</label></li>
                    <li><input type="checkbox" id="bugatti" name="brand" value="Bugatti"><label for="bugatti">Bugatti</label></li>
                    <li><input type="checkbox" id="buick" name="brand" value="Buick"><label for="buick">Buick</label></li>
                    <li><input type="checkbox" id="cadillac" name="brand" value="Cadillac"><label for="cadillac">Cadillac</label></li>
                    <li><input type="checkbox" id="chevrolet" name="brand" value="Chevrolet"><label for="chevrolet">Chevrolet</label></li>
                    <li><input type="checkbox" id="chrysler" name="brand" value="Chrysler"><label for="chrysler">Chrysler</label></li>
                    <li><input type="checkbox" id="dodge" name="brand" value="Dodge"><label for="dodge">Dodge</label></li>
                </ul>
            </div>
        </form>
    </aside> 
    <section id="products">

<?php
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    $db = getDatabaseConnection();
    $products = Product::getAllProducts($db);

    foreach ($products as $product) {?>
        <article>
            <img src="../images/products/<?= $product->id ?>.jpg" alt="<?= $product->title ?>">
            <h1><?= $product->title ?></h3>
            <p>€<?= $product->price ?></p>
            <button class="add-wishlist">Add to Wishlist</button>
        </article>
    <?php } ?>
    </section>

<?php drawFooter(); ?>