<?php 
declare(strict_types = 1); 
require_once(__DIR__ . '/../database/notification.class.php');
?>

<?php function calculateDeliveryDate($startDay, $endDay) {
    $date1 = new DateTime();
    $date1->modify('+' . $startDay . ' day');
    $date2 = new DateTime();
    $date2->modify('+' . $endDay . ' days');
    return '<p>Estimated delivery ' . $date1->format('l, j F') . ' - ' . $date2->format('l, j F') . '</p>';
} ?>

<?php function drawCheckoutPage($db, $user, $address, $product) { ?>
    <h1 id="checkout-heading">Checkout</h1>
    <div class="checkout-container">
        <div class="checkout-steps">
            <div id="checkoutUserInfo" class="checkout-user-info" data-expanded="true" onclick="toggleUserInfo()">
                <h2>1. User Information</h2>
                <div class="info-box">
                    <label>Username</label>
                    <p class="info-rectangle"><?= htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="info-box">
                    <label>Name</label>
                    <p class="info-rectangle"><?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="info-box">
                    <label>Phone Number</label>
                    <p class="info-rectangle"><?= htmlspecialchars($user->phoneNumber, ENT_QUOTES, 'UTF-8') ?></p>
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
            <div id="paymentMethod" class="payment-method" data-expanded="false" onclick="togglePaymentMethod()">
                <h2>3. Payment Method</h2>
                <div id="paymentMethodSelect" class="payment-box">
                    <div class="radio-option rectangle">
                        <input type="radio" id="creditCard" name="paymentMethod" value="creditCard" checked>
                        <span class="method">Credit Card</span>
                        <div class="payment-details">
                            <div class="align-start">
                                <label for="cardHolder">Name on card</label>
                                <input type="text" id="cardHolder" name="cardHolder" placeholder="John Doe">
                            </div>
                            <div class="align-start">
                                <label for="cardNumber">Card number</label>
                                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="row">
                                <div>
                                    <label for="expiryDate">Expiry date</label>
                                    <div class="expiry">
                                        <input type="text" id="expiryMonth" name="expiryMonth" placeholder="MM" maxlength="2">
                                        <span id="slash">/</span>
                                        <input type="text" id="expiryYear" name="expiryYear" placeholder="YY" maxlength="2">
                                    </div>
                                </div>
                                <div>
                                    <div class="cvv-container">
                                        <label for="cvv">CVC/CVV</label>
                                        <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="radio-option rectangle">
                        <input type="radio" id="mbway" name="paymentMethod" value="mbway">
                        <span class="method">MBWay</span>
                        <div class="payment-details">
                            <div class="align-start">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" maxlength="9">
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <form action="waitPayment.php" method="post">
                <input type="hidden" name="productId" value="<?= $product->id ?>">
                <input type="hidden" name="totalToPay" id="totalToPayInput">
                <input type="hidden" name="selectedPaymentMethod" id="selectedPaymentMethod">
                <input type="hidden" name="paymentDetails" id="paymentDetails">
                <button type="submit">Checkout</button>
            </form>
        </div>
        <div class="product-box">
            <div class="product-content">
                <div class="product-image">
                    <img src="../database/images/<?= $product->getProductThumbnail($db) ?>">
                </div>
                <div class="product-details">
                    <h2>€ <?= $product->price ?></h2>
                    <h2><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?></h2>
                    <p><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="line"></div>
            </div>
            <div class="subtotal">
                Subtotal: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
            <div id="shippingCost" class="subtotal">
            </div>
            <div class="total">
                TOTAL TO PAY: <span class="checkout-price">€ <?= $product->price ?></span>
            </div>
        </div>
    </div>
<?php } ?>

<?php function processPayment($db, $session, $user) { 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productId = isset($_POST['productId']) ? $_POST['productId'] : null;
        $totalToPay = isset($_POST['totalToPay']) ? $_POST['totalToPay'] : null;
        $selectedPaymentMethod = isset($_POST['selectedPaymentMethod']) ? $_POST['selectedPaymentMethod'] : null;
        $paymentDetails = isset($_POST['paymentDetails']) ? $_POST['paymentDetails'] : null;
        
        $product = Product::getProductById($db, $productId);

        $isPaymentSuccessful = rand(1, 4) !== 1;
        if ($isPaymentSuccessful) {
            $session->addMessage('success', 'Payment Successful! Your order has been placed.');

            $order = new Order(
                0, 
                $user->username, 
                (int)$productId, 
                (float)$totalToPay, 
                $product->sellerId, 
                date('Y-m-d H:i:s'),
                $selectedPaymentMethod, 
                $selectedPaymentMethod === 'MB WAY' ? $paymentDetails : null,
                $selectedPaymentMethod === 'Credit Card' ? $paymentDetails : null
            );

            if (!$order->saveToOrderTable($db)) {
                $session->addMessage('error', 'There was a problem processing your order. Please try again.');
            } else {
                $product->removeFromWishlist($db, $session->getUsername());
                $product->setProductState($db, (int)$productId, 'Sold');
                Notification::addNotification($db, $product->sellerId, 'Sold');
            }
        } else {
            $session->addMessage('error', 'Payment Failed! Please try again.');
        }
    } ?>
    <div id="waitingAnimationContainer">
        <div class="loader"></div>
        <div id="waitingAnimationText">Processing your payment...</div>    
    </div>
<?php }?>

<?php function drawReceipt($db, $order, $user, $seller, $userAddress, $sellerAddress, $product, $brand, $scale, $category) { ?>
    <h1 id="receipt-heading">Receipt</h1>
    <div class="receipt-container">
        <div id="receipt-header"></div>
        <div class="receipt-info">
            <label>Order ID: <?= $order->orderId?></label>
            <label>Order Date: <?= $order->orderDate?></label>
        </div>
        <div class="receipt-user-info">
            <label>Client</label>
            <div class="user-info-box">
                <p><?= htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8') ?></p>
                <p><?= htmlspecialchars($user->phoneNumber, ENT_QUOTES, 'UTF-8') ?></p>
                <div class="address-line">
                    <?=htmlspecialchars($userAddress->address, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($userAddress->postalCode, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($userAddress->city, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($userAddress->country, ENT_QUOTES, 'UTF-8')?>
                </div>
            </div>
        </div>
        <div class="receipt-user-info">
            <label>Seller</label>
            <div class="user-info-box">
                <p><?= htmlspecialchars($seller->name, ENT_QUOTES, 'UTF-8')?></p>
                <p><?= htmlspecialchars($seller->phoneNumber, ENT_QUOTES, 'UTF-8')?></p>
                <div class="address-line">
                    <?=htmlspecialchars($sellerAddress->address, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($sellerAddress->postalCode, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($sellerAddress->city, ENT_QUOTES, 'UTF-8')?>,
                    <?=htmlspecialchars($sellerAddress->country, ENT_QUOTES, 'UTF-8')?>
                </div>
            </div>
        </div>
        <div class="product-info">
            <label>Product</label>
            <div class="product-info-box">
                <p id="product-label">Brand: <span id="product-name"><?= htmlspecialchars($brand->name, ENT_QUOTES, 'UTF-8')?></span></p>
                <p id="product-label">Name: <span id="product-name"><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8')?></span></p>
                <p id="product-label">Scale: <span id="product-name"><?= htmlspecialchars($scale->name, ENT_QUOTES, 'UTF-8')?></span></p>
                <p id="product-label">Category: <span id="product-name"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8')?></span></p>
            </div>
        </div>
        <div class="payment-info">
            <label>Payment Method</label>
            <div class="payment-info-box">
                <p><?= htmlspecialchars($order->paymentMethod, ENT_QUOTES, 'UTF-8') ?></p>
                <?php if ($order->paymentMethod == 'Credit Card'): ?>
                    <p>Card number: <?= htmlspecialchars($order->cardNumber, ENT_QUOTES, 'UTF-8') ?></p>
                <?php else: ?>
                    <p>Phone number: <?= htmlspecialchars($order->phoneNumber, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="cost-stamp-container">
            <div class="receipt-stamp"></div>
            <div class="cost-info">
                <p id="subtotal">Subtotal: <span class="price">€<?= $product->price?></span></p>
                <p id="shipping">Shipping: <span class="price">€<?= ($order->totalPrice == $product->price) ? '0' : '5.99';?></span></p>
                <p id="line"></p>
                <p id="total">Total: <span class="price">€<?= $order->totalPrice?></span></p>
            </div>
        </div>
    </div>
    <button id="downloadPdf"><i class="fas fa-download"></i> Download Receipt as PDF</button>
<?php } ?>