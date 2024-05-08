<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../../utils/session.php');
require_once(__DIR__ . '/../../database/connection.db.php');
require_once(__DIR__ . '/../../database/user.class.php');

$session = new Session();

if (!$session->isLoggedIn()) {
    header('Location: ../pages/login.php');
    exit();
}

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
    drawProfileContent($user, $address);
?>
