<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/account.tpl.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: /pages/login.php');
    exit();
}

drawHeader2();
drawMessages($session);

$db = getDatabaseConnection();
$user = User::getUserByUsername($db, $session->getUsername());
$address = Address::getAddressById($db, $user->addressId);

?>

<section id="account">
    <div class="account-navbar">
        <a href="#" class="nav-link" data-content="profile"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="#" class="nav-link" data-content="my-orders"><i class="fa-solid fa-receipt"></i> My Orders</a>
        <a href="#" class="nav-link" data-content="my-sells"><i class="fa-solid fa-cart-shopping"></i> My Sells/Solds</a>
    </div>

    <div class="account-content">
        <?php drawProfileContent($user, $address); ?>
    </div>
</section>

<?php
    drawfooter();
?>
