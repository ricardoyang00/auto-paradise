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

    drawHeader2();
    drawMessages($session);
    
    $db = getDatabaseConnection();
    
    $user = User::getUserByUsername($db, $session->getUsername());
?>

<?php
    $isPaymentSuccessful = rand(1, 4) !== 1;
    if ($isPaymentSuccessful) {
        $session->addMessage('success', 'Payment Successful! Your order has been placed.');
    } else {
        $session->addMessage('error', 'Payment Failed! Please try again.');
    }
?>

<div id="waitingAnimation">Processing your payment...</div>


<?php
    drawFooter();
?>