<?php declare(strict_types = 1); ?>

<?php function drawLoginForm() { ?>
    <div class="loginRegister">
    <form id="login-form" class="user-form" action="../actions/action_login.php" method="post">
        <label for="loginUsername">Username</label>
        <input type="text" id="loginUsername" name="loginUsername" required>
            
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="loginPassword" required>

        <input type="submit" value="Log in">
        <div class="account-link">
            Don't have an account? <a href="register.php">Sign up</a>
        </div>
    </form>
    </div>
<?php } ?>

<?php function drawRegisterForm() { ?>
    <div class="loginRegister">
    <form id="register-form" class="user-form" action="../actions/action_register.php" method="post">
        <label for="registerUsername">Username</label>
        <input type="text" id="registerUsername" name="registerUsername" required>

        <label for="registerName">Name</label>
        <input type="text" id="registerName" name="registerName" required>
    
        <label for="registerPassword">Password</label>
        <input type="password" id="registerPassword" name="registerPassword" required>
    
        <label for="registerPhoneNumber">Phone number</label>
        <input type="text" id="registerPhoneNumber" name="registerPhoneNumber" required>

        <label for="registerAddress">Address</label>
        <input type="text" id="registerAddress" name="registerAddress" required>

        <label for="registerPostalCode">Postal Code</label>
        <input type="text" id="registerPostalCode" name="registerPostalCode" required>

        <label for="registerCity">City</label>
        <input type="text" id="registerCity" name="registerCity" required>

        <label for="registerCountry">Country</label>
        <input type="text" id="registerCountry" name="registerCountry" required>

        <input type="submit" value="Register">
        <div class="account-link">
            Already have an account? <a href="profile.php">Log in</a>
        </div>
    </form>
    </div>
<?php } ?>

<?php function drawProfile($user, $address, $isEditable = false) { 
    if ($isEditable) { ?>
        <h1 id="profile-heading">Profile (Editing)</h1>
        <form action="../actions/action_update_profile.php" method="post">
    <?php } else { ?>
        <h1 id="profile-heading">Profile</h1>    
    <?php } ?>

    <div class="profile">
        <?php if (!$isEditable) { ?>
            <a href="../actions/action_edit_profile.php" class="edit-icon">
                <i class="fas fa-pen"></i>
            </a>
        <?php } ?>

        <div class="user-label">Username</div>
        <div class="data-container">
            <span class="user-data" id="username"><?=$user->username?></span>
        </div>

        <div class="user-label">Name</div>
        <div class="data-container">
            <?php if ($isEditable) { ?>
                <input type="text" id="name" name="name" value="<?=$user->name?>" required>
            <?php } else { ?>
                <span class="user-data" id="name"><?=$user->name?></span>
            <?php } ?>
        </div>

        <div class="user-label">Phone Number</div>
        <div class="data-container">
        <?php if ($isEditable) { ?>
                <input type="text" id="phoneNumber" name="phoneNumber" value="<?=$user->phoneNumber?>" required>
            <?php } else { ?>
                <span class="user-data" id="phoneNumber"><?=$user->phoneNumber?></span>
            <?php } ?>
        </div>

        <?php if ($address !== null) { ?>
            <div class="user-label">Address</div>
            <div class="data-container">
                <?php if ($isEditable) { ?>
                    <input type="text" id="address" name="address" value="<?=$address->address?>" required>
                <?php } else { ?>
                    <span class="user-data" id="address"><?=$address->address?></span>
                    <span class="user-data" id="postalCode"><?=$address->postalCode?></span>,
                    <span class="user-data" id="city"><?=$address->city?></span>,
                    <span class="user-data" id="country"><?=$address->country?></span>
                <?php } ?>
            </div>
            
            <?php if ($isEditable) { ?>
                <div class="user-label">Postal Code</div>
                <div class="data-container">
                    <input type="text" id="postalCode" name="postalCode" value="<?=$address->postalCode?>" required>
                </div>

                <div class="user-label">City</div>
                <div class="data-container">
                    <input type="text" id="city" name="city" value="<?=$address->city?>" required>
                </div>

                <div class="user-label">Country</div>
                <div class="data-container">
                    <input type="text" id="country" name="country" value="<?=$address->country?>" required>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
    <div class="button-container">
        <?php if ($isEditable) { ?>
                <a href="../pages/profile.php" class="profile-button" id="cancel">Cancel</a>
                <button type="submit" class="profile-button" id="save">Save</button>
            </form>
        <?php } else { ?>
            <a href="../actions/action_change_password.php" class="profile-button" id="change-password">Change Password</a>
            <form action="../actions/action_logout.php" method="post">
                <button type="submit" class="profile-button" id="logout">Logout</button>
            </form>
        <?php } ?>
    </div>
<?php } ?>

<?php function drawChangePasswordForm() { ?>
    <h1 id="profile-heading">Change Password</h1>

    <div class="profile">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="user-label">Current Password</div>
            <div class="data-container">
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>
    
            <div class="user-label">New Password</div>
            <div class="data-container">
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
    
            <div class="button-container">
                <a href="../pages/profile.php" class="profile-button" id="cancel">Cancel</a>
                <button type="submit" class="profile-button" id="change-password">Change Password</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function updateProfile($db, $session, $post) {
    $user = User::getUserByUsername($db, $session->getUsername());
    
    if (isset($post['name'])) {
        $user->name = $post['name'];
    }
    if (isset($post['phoneNumber'])) {
        $user->phoneNumber = $post['phoneNumber'];
    }
    
    $address = $user->getUserAddress($db);
    if (isset($post['postalCode'])) {
        $address->postalCode = $post['postalCode'];
    }
    if (isset($post['address'])) {
        $address->address = $post['address'];
    }
    if (isset($post['city'])) {
        $address->city = $post['city'];
    }
    if (isset($post['country'])) {
        $address->country = $post['country'];
    }

    $addressId = Address::getAddressByDetails($db, $address->postalCode, $address->address, $address->city, $address->country);
    if ($addressId === null) {
        $addressObj = new Address(0, $address->postalCode, $address->address, $address->city, $address->country);
        $addressId = $addressObj->saveToAddressTable($db);
    }

    $user->addressId = $addressId;
    $user->updateProfile($db);
    
    $session->addMessage('success', 'Profile updated!');
    header('Location: ../pages/profile.php');
    exit();
} ?>

<?php function changePassword($db, $session, $post, $user) {
    $oldPassword = $post['oldPassword'];
    $newPassword = $post['newPassword'];

    if ($user->checkPassword($oldPassword)) {
        if ($oldPassword == $newPassword) {
            $session->addMessage('error', 'New password cannot be the same as the current password!');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $result = $user->changePassword($db, $oldPassword, $newPassword);
        
            if ($result) {
                $session->addMessage('success', 'Password changed successfully!');
                header('Location: ../pages/profile.php');
                exit();
            } else {
                $session->addMessage('error', 'Failed to change password!');
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    } else {
        $session->addMessage('error', 'Wrong current password!');
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
} ?>