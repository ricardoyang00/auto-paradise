<?php
    declare(strict_types = 1);

    function calculateDeliveryDate($startDay, $endDay) {
        $date1 = new DateTime();
        $date1->modify('+' . $startDay . ' day');
        $date2 = new DateTime();
        $date2->modify('+' . $endDay . ' days');
        return '<p>Estimated delivery ' . $date1->format('l, j F') . ' - ' . $date2->format('l, j F') . '</p>';
    }

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
    require_once(__DIR__ . '/../templates/account.tpl.php');
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
        <div class="checkout-steps">
            <div id="checkoutUserInfo" class="checkout-user-info" data-expanded="true" onclick="toggleUserInfo()">
                <h2>1. User Information</h2>
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
            <div id="shippingMethod" class="shipping-method" data-expanded="false" onclick="toggleShippingMethod()">
                <h2>2. Shipping Method</h2>
                <div id="shippingMethodSelect" class="shipping-box">
                    <div class="radio-option">
                        <input type="radio" id="standard" name="shippingMethod" value="standard" checked>
                        <div class="method-delivery">
                            <span class="method">Standard</span>
                            <div class="delivery-date">
                                <?php echo calculateDeliveryDate(3, 5); ?>
                            </div>
                        </div>
                        <span class="cost">Free</span>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="express" name="shippingMethod" value="express">
                        <div class="method-delivery">
                            <span class="method">Express</span>
                            <div class="delivery-date">
                                <?php echo calculateDeliveryDate(1, 3); ?>
                            </div>
                        </div>
                        <span class="cost">€5.99</span>
                    </div>
                </div>
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
                Subtotal: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
            <div id="shippingCost" class="subtotal">
                <!-- This is filled in by checkout.js -->
            </div>
            <div class="total">
                TOTAL TO PAY: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
        </div>
    </div>
    
    <?php drawFooter();
?>