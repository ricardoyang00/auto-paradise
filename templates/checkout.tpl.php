<?php declare(strict_types = 1); ?>

<?php function drawProductBox($db, $product) { ?>
    <div class="product-box">
        <div class="product-content">
            <div class="product-image">
                <img src="../database/images/<?= $product->getProductThumbnail($db) ?>">
            </div>
            <div class="product-details">
                <h2>€ <?= $product->price ?></h2>
                <h2><?= $product->title ?></h2>
                <p><?= $product->description ?></p>
            </div>
            <div class="line"></div>
        </div>
        <div class="subtotal">
            Subtotal: <span id="price">€ <?= $product->price ?></span>
        </div>
        <div class="total">
            TOTAL TO PAY: <span id="price">€ <?= $product->price ?></span>
        </div>
    </div>
<?php } ?>