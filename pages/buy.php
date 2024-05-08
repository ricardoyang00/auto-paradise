<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/profile.tpl.php');
    require_once(__DIR__ . '/../templates/checkout.tpl.php');

    drawHeader2();
    drawMessages($session);

    $db = getDatabaseConnection();
    
    $user = User::getUserByUsername($db, $session->getUsername());
    $address = Address::getAddressById($db, $user->addressId);

    $productId = $_GET['product_id'];
    $product = Product::getProductById($db, $productId);

    ?>

    <script src="../javascript/checkout.js"></script>

    <h1 id="checkout-heading">Checkout</h1>
    <div class="checkout-container">
        <div id="checkoutUserInfo" class="checkout-user-info" onclick="toggleUserInfo()">
            <h2>User Information</h2>
            <div class="info-box">
                <label>Username</label>
                <p class="info-rectangle"><?= $user->username ?></p>
            </div>
            <div class="info-box">
                <label>Name</label>
                <p class="info-rectangle"><?= $user->name ?></p>
            </div>
            <div class="info-box">
                <label>Phone Number</label>
                <p class="info-rectangle"><?= $user->phoneNumber ?></p>
            </div>
            <div class="info-box">
                <label>Address</label>
                <p class="info-rectangle" id="inline">
                    <?=$address->address?>,
                    <?=$address->postalCode?>,
                    <?=$address->city?>,
                    <?=$address->country?>
                </p>
            </div>
        </div>
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
    </div>
    
    <?php drawFooter();
?>