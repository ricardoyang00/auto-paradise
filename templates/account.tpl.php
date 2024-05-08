<?php
function drawProfileContent($user, $address) { ?>
    <h2>Profile</h2>
    <div id="profile" class="account-content">
        <div class="profile-content">
            <a href="#" class="edit-icon"><i class="fas fa-pen"></i></a>

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
        <form action="../actions/action_logout.php" method="post">
            <button type="submit" class="profile-button" id="logout">Logout</button>
        </form>
    </div>
<?php } ?>