<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/scale.class.php');
    require_once(__DIR__ . '/../database/brand.class.php');
    require_once(__DIR__ . '/../database/category.class.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/question.class.php');

    $db = getDatabaseConnection();
?>

<?php function drawProductList($db, $products, $searchQuery) {
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

<?php function drawProductItem(Product $product, $isAdmin) {
    $db = getDatabaseConnection();
    $seller = User::getUserByUsername($db, $product->sellerId);
    $category = Category::getCategoryById($db, $product->category);
    $brand = Brand::getBrandById($db, $product->brandId);
    $scale = Scale::getScaleById($db, $product->scale); ?>

    <section id="item">
        <div class="container">
            <div class="image">
                <?php $url = "item.php?id=" . $product->id; ?>
                <div class="carousel">
                    <div class="carousel-inner">
                        <?php 
                        $images = $product->getProductImages($db);
                        foreach($images as $index => $image) {
                            echo '<img src="../database/images/' . $image . '" alt="Product Image" class="carousel-image' . ($index === 0 ? ' active' : '') . '">';
                        }
                        ?>
                    </div>
                    <a class="carousel-prev">&#10094;</a>
                    <a class="carousel-next">&#10095;</a>
                </div>
            </div>
            <div class="title">
            <?php
            if ($isAdmin) { ?>
                <a href="#" class="ban-icon" onclick="showBanPopup(<?= $product->id ?>)"><i class="fa-solid fa-ban"></i></a>
            <?php
            }?>
                <section id="tags">
                    <h2><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8') ?></h2>
                    <h2><?= htmlspecialchars($scale->name, ENT_QUOTES, 'UTF-8') ?></h2>
                    <h2><?= htmlspecialchars($brand->name, ENT_QUOTES, 'UTF-8') ?></h2>
                </section>
                <h1><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?></h1>
                <h3>€<?= $product->price ?></h3>
                <button class="buy" data-id="<?= $product->id ?>">
                    <a href="buy.php?product_id=<?= $product->id ?>"> Buy Now </a>
                </button>
                <button class="add-wishlist" onclick="addToWishlist(<?= $product->id ?>)"><i class="fa-regular fa-heart"></i></a></button> 
            </div>
            <div class="seller-info">
                <h2>Seller Information</h2>
                <p class="user-name"><i class="fa-solid fa-user"></i><?= htmlspecialchars($seller->name, ENT_QUOTES, 'UTF-8') ?></p>
                <p class="location"><i class="fa-solid fa-location-dot"></i><?=$seller->getUserAddress($db)->city?>, <?=$seller->getUserAddress($db)->country?></p>
            </div>
            <div class="description">
                <h2>Description</h2>
                <p><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="qna">
                <h2>Q&A</h2>
                <div id="question-form">
                    <textarea id="question-text" placeholder="Ask a question..."></textarea>
                    <button type="button" id="submit-question">Submit</button>
                </div>
                <?php
                $questions = Questions::getProductQuestions($db, $product->id);
                foreach($questions as $question) { 
                    if (isset($question->answer) && $question->answer !== null) { ?>
                        <div class="qa-item">
                            <p><strong>Q: </strong><?=$question->question?></p>
                            <p><strong>A: </strong><?=$question->answer?></p>
                        </div>
                    <?php }
                } ?>                
            </div>
        </div>
    </section>
    <div id="banPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeBanPopup()">&times;</span>
            <h2>Ban Product</h2>
            <textarea id="banReason" rows="4" cols="50" placeholder="Enter ban reason"></textarea>
            <button onclick="banProduct(<?= $product->id ?>)" id="ban-button">Ban</button>
        </div>
    </div>
<?php } ?>

<?php function drawEditProductForm($db, $categories, $brands, $scales, $product, $productId, $productCategory, $productBrand, $productScale) { ?>
    <section id="edit-product">
        <h2>Edit product</h2>
        <form action="../../actions/action_update_product.php" method="post">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($productId, ENT_QUOTES, 'UTF-8') ?>">
            <div class="input-container">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="input-container">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>
            <div class="input-container">
                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="" disabled>Select a category</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= ($category->id == $productCategory->id) ? 'selected' : '' ?>>
                            <?= $category->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-container">
                <label for="brand">Brand</label>
                <select id="brand" name="brand" required>
                    <option value="" disabled>Select a brand</option>
                    <?php foreach($brands as $brand): ?>
                        <option value="<?= $brand->id ?>" <?= ($brand->id == $productBrand->id) ? 'selected' : '' ?>>
                            <?= $brand->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>  
            </div>
            <div class="input-container">
                <label for="scale">Scale</label>
                <select id="scale" name="scale" required>
                    <option value="" disabled>Select a scale</option>
                    <?php foreach($scales as $scale): ?>
                        <option value="<?= $scale->id ?>" <?= ($scale->id == $productScale->id) ? 'selected' : '' ?>>
                            <?= $scale->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>  
            </div>
            <div class="input-container">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?= $product->price ?>" required>
            </div>
            <button type="submit">Save</button>
        </form>
    </section>
<?php } ?>