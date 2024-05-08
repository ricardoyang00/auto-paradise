<?php

declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');

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

function drawProfileContent($user, $address) { ?>
<h2>Profile</h2>
        <div id="profile" class="account-content">
            <div class="profile-content">
                <a href="../actions/action_edit_profile.php" class="edit-icon"><i class="fas fa-pen"></i></a>

                <h3>Username</h3>
                <div class="data-container">
                    <p id="username"><?=$user->username?></p>
                </div>

                <h3>Name</h3>
                <div class="data-container">
                    <p><?=$user->name?></p>
                </div>

                <h3>Phone Number</h3>
                <div class="data-container">
                    <p><?=$user->phoneNumber?></p>
                </div>

                <h3>Address</h3>
                <div class="data-container">
                    <p><?=$address->address?>, <?=$address->postalCode?>, <?=$address->city?>, <?=$address->country?></p>
                </div>
        </div>
<?php } 

function drawMyOrdersContent() { ?>
    <h2>My Orders</h2>
    <div id="my-orders" class="account-content">
        <div class="orders-content">
            <p>This is where you can display the list of orders made by the user.</p>
            <p>You can customize this section as needed to show order details.</p>
        </div>
    </div>
<?php } 

function drawMySellsContent() { ?>
    <h2>My Sells/Solds</h2>
    <div id="my-sells" class="account-content">
        <div class="sells-content">
            <p>This is where you can display the list of products sold by the user.</p>
            <p>You can customize this section as needed to show product details.</p>
        </div>
    </div>
<?php } ?>

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
