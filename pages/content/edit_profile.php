<?php

declare (strict_types = 1);
require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/user.class.php');

$section = new Session();
if (!$section->isLoggedIn()) {
    header('Location: ../../pages/login.php');
    exit();
}

$db = getDatabaseConnection();
$user = User::getUserByUsername($db, $section->getUsername());
$address = Address::getAddressById($db, $user->addressId);

function drawProfileEdit($user, $address) { ?>
<h2>Profile &nbsp;&nbsp;(editing)</h2>
<div id="profile" class="account-content">
    <form action="../../actions/action_update_profile.php" method="post">
        <div class="profile-content">
            <h3>Username</h3>
            <div class="data-container">
                <p id="username"><?=$user->username?></p>
            </div>
            
            <h3>Name</h3>
            <div class="data-container">
                <input type="text" id="name" name="name" value="<?=$user->name?>">
            </div>

            <h3>Phone Number</h3>
            <div class="data-container">
                <input type="text" id="phoneNumber" name="phoneNumber" value="<?=$user->phoneNumber?>">
            </div>

            <h3>Address</h3>
            <div class="data-container">
                <input type="text" id="address" name="address" value="<?=$address->address?>">
            </div>

            <h3>Postal Code</h3>
            <div class="data-container">
                <input type="text" id="postalCode" name="postalCode" value="<?=$address->postalCode?>">
            </div>

            <h3>City</h3>
            <div class="data-container">
                <input type="text" id="city" name="city" value="<?=$address->city?>">
            </div>

            <h3>Country</h3>
            <div class="data-container">
                <input type="text" id="country" name="country" value="<?=$address->country?>">
            </div>
        </div>
        <div class="icon-and-button">
            <button type="submit" class="profile-button" id="save">Save</button>
        </div>
    </form>
</div>

<?php } 

drawProfileEdit($user, $address);
?>