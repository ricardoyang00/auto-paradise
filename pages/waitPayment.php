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
    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../templates/checkout.tpl.php');

    drawHeader(false);
    drawMessages($session);
    
    $db = getDatabaseConnection();
    
    $user = User::getUserByUsername($db, $session->getUsername());
    $address = Address::getAddressById($db, $user->addressId);

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
            }
        } else {
            $session->addMessage('error', 'Payment Failed! Please try again.');
        }
    }
?>

<div id="waitingAnimationContainer">
    <div class="loader"></div>
    <div id="waitingAnimationText">Processing your payment...</div>    
</div>

<?php
    drawFooter();
?>