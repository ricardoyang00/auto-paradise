<?php 
    declare(strict_types = 1); 
    require_once(__DIR__ . '/../database/product.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
?>

<?php function drawNavBar($user, $address, $isAdmin) { ?>
    <section id="account">
        <div class="account-navbar">
            <a href="#" class="nav-link selected" data-content="profile"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="#" class="nav-link" data-content="my-orders"><i class="fa-solid fa-receipt"></i> My Orders</a>
            <a href="#" class="nav-link" data-content="my-solds"><i class="fa-solid fa-cart-shopping"></i> My Solds</a>
            <a href="#" class="nav-link" data-content="my-listings"><i class="fa-solid fa-shop"></i> My Listings</a>
            <?php
                if ($isAdmin) { ?>
                    <a href="#" class="nav-link" data-content="admin"><i class="fa-solid fa-crown"></i> Admin</a>
            <?php } ?>
        </div>
        
        <div class="account-content">
            <?php drawProfileContent($user, $address); ?>
        </div>
    </section>
<?php } ?>

<?php function drawProfileContent($user, $address) { ?>
    <h2>Profile</h2>
    <div id="profile" class="account-content">
        <div class="profile-content">
            <a href="#" class="edit-icon"><i class="fas fa-pen"></i></a>

            <h3>Username</h3>
            <div class="data-container">
                <p id="username"><?=htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8')?></p>
            </div>

            <h3>Name</h3>
            <div class="data-container">
                <p><?=htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8')?></p>
            </div>

            <h3>Phone Number</h3>
            <div class="data-container">
                <p><?=htmlspecialchars($user->phoneNumber, ENT_QUOTES, 'UTF-8')?></p>
            </div>

            <h3>Address</h3>
            <div class="data-container">
                <p>
                    <?=htmlspecialchars($address->address, ENT_QUOTES, 'UTF-8')?>, 
                    <?=htmlspecialchars($address->postalCode, ENT_QUOTES, 'UTF-8')?>, 
                    <?=htmlspecialchars($address->city, ENT_QUOTES, 'UTF-8')?>, 
                    <?=htmlspecialchars($address->country, ENT_QUOTES, 'UTF-8')?></p>
            </div>
        </div>
        <div class="icon-and-button">
            <a href="#" class="change-password-icon"><i class="fa-solid fa-lock"></i></a>
            <form action="../actions/action_logout.php" method="post">
                <button type="submit" class="profile-button" id="logout">Logout</button>
            </form>
        </div>
    </div>
<?php } ?>

<?php function drawProfileEdit($user, $address) { ?>
    <h2>Profile &nbsp;&nbsp;(editing)</h2>
    <div id="profile" class="account-content">
        <form action="../../actions/action_update_profile.php" method="post">
            <div class="profile-content">
                <h3>Username</h3>
                <div class="data-container">
                    <p id="username"><?=htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8')?></p>
                </div>

                <h3>Name</h3>
                <div class="data-container">
                    <input type="text" id="name" name="name" value="<?=htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8')?>">
                </div>

                <h3>Phone Number</h3>
                <div class="data-container">
                    <input type="text" id="phoneNumber" name="phoneNumber" value="<?=htmlspecialchars($user->phoneNumber, ENT_QUOTES, 'UTF-8')?>">
                </div>

                <h3>Address</h3>
                <div class="data-container">
                    <input type="text" id="address" name="address" value="<?=htmlspecialchars($address->address, ENT_QUOTES, 'UTF-8')?>">
                </div>

                <h3>Postal Code</h3>
                <div class="data-container">
                    <input type="text" id="postalCode" name="postalCode" value="<?=htmlspecialchars($address->postalCode, ENT_QUOTES, 'UTF-8')?>">
                </div>

                <h3>City</h3>
                <div class="data-container">
                    <input type="text" id="city" name="city" value="<?=htmlspecialchars($address->city, ENT_QUOTES, 'UTF-8')?>">
                </div>

                <h3>Country</h3>
                <div class="data-container">
                    <input type="text" id="country" name="country" value="<?=htmlspecialchars($address->country, ENT_QUOTES, 'UTF-8')?>">
                </div>
            </div>
            <div class="icon-and-button">
                <button type="submit" class="profile-button" id="save">Save</button>
            </div>
        </form>
    </div>
<?php } ?>

<?php function drawChangePasswordForm() { ?>
    <h2>Profile &nbsp;&nbsp;(password)</h2>
    <div id="profile" class="account-content">
        <form method="post" action="../actions/action_change_password.php">
            <div class="profile-content">
                <h3>Current Password</h3>
                <div class="data-container">
                    <input type="password" id="oldPassword" name="oldPassword" required>
                </div>
                <h3>New Password</h3>
                <div class="data-container">
                    <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <h3>Confirm New Password</h3>
                    <div class="data-container">
                <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>
            </div>
            </div>
            <div class="icon-and-button">
                <button type="submit" class="profile-button" id="change-password">Change Password</button>
            </div>
        </form>
    </div>
<?php } ?>

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
        <input type="text" id="registerUsername" name="registerUsername" pattern="[A-Za-z0-9_]{3,20}" title="Username should be 3-20 characters long and can only contain letters, numbers, and underscores." required>

        <label for="registerName">Name</label>
        <input type="text" id="registerName" name="registerName" pattern="[A-Za-z ]+" title="Name can only contain letters and spaces." maxlength="50" required>
    
        <label for="registerPassword">Password</label>
        <input type="password" id="registerPassword" name="registerPassword" minlength="8" title="Password must be at least 8 characters long." maxlength="30" required>
    
        <label for="registerPhoneNumber">Phone number</label>
        <input type="text" id="registerPhoneNumber" name="registerPhoneNumber" pattern="\d{9}" title="Phone number must be 9 digits long." maxlength="9" required>

        <label for="registerAddress">Address</label>
        <input type="text" id="registerAddress" name="registerAddress" pattern="[A-Za-z0-9. ]+" title="Address can only contain letters, numbers, spaces and points." maxlength="60" required>

        <label for="registerPostalCode">Postal Code</label>
        <input type="text" id="registerPostalCode" name="registerPostalCode" pattern="\d{4}-\d{3}" title="Postal Code must be in the format 1234-123." required>
        
        <label for="registerCity">City</label>
        <input type="text" id="registerCity" name="registerCity" pattern="[A-Za-z ]+" title="City can only contain letters and spaces." maxlength="30" required>

        <label for="registerCountry">Country</label>
        <input type="text" id="registerCountry" name="registerCountry" pattern="[A-Za-z ]+" title="Country can only contain letters and spaces." maxlength="30" required>

        <input type="submit" value="Register">
        <div class="account-link">
            Already have an account? <a href="profile.php">Log in</a>
        </div>
    </form>
    </div>
<?php } ?>

<?php function drawTransactions($db, $transactions, $type) {
    $title = htmlspecialchars($type === 'orders' ? 'My Orders' : 'My Solds', ENT_QUOTES, 'UTF-8');
    $divId = htmlspecialchars($type === 'orders' ? 'my-orders' : 'my-solds', ENT_QUOTES, 'UTF-8'); ?>
    <h2><?= $title ?></h2>
    <div id="<?= $divId ?>" class="account-content">
        <div class="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?> ?>-content">
            <?php foreach ($transactions as $transaction):
                $product = Product::getProductById($db, $transaction->productId);
                $thumbnail = htmlspecialchars($product->getProductThumbnail($db), ENT_QUOTES, 'UTF-8'); ?>
                <article>
                    <img src="../database/images/<?= $thumbnail ?>">
                    <div id="product-information">
                        <a href="../pages/item.php?id=<?=$product->id;?>"><h1><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?></h1></a>
                        <p><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($transaction->orderDate, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div id="product-price-receipt">
                        <p>€ <?= $transaction->totalPrice ?></p>
                        <div id="actions">
                        <button class="receipt" data-id="<?= $transaction->orderId ?>">
                                <a href="receipt.php?order_id=<?= $transaction->orderId ?>">
                                    Receipt <i class="fa-solid fa-file-invoice"></i>
                                </a>    
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>

<?php function drawListings($db, $listings) { 
    $db = getDatabaseConnection(); ?>
    <h2>My Listings</h2>
    <div id="my-listings" class="account-content">
        <div class="listings-content">
            <?php foreach ($listings as $product):
                $thumbnail = htmlspecialchars($product->getProductThumbnail($db), ENT_QUOTES, 'UTF-8'); ?>
                <article>
                    <?php
                        if (Product::isBanned($db, $product->id)) {
                            $bannedReason = Product::getBannedReason($db, $product->id); ?>
                            <p class='banned'>Banned: <?=htmlspecialchars($bannedReason, ENT_QUOTES, 'UTF-8');?></p>
                    <?php } ?>
                    <img src="../database/images/<?= $thumbnail ?>">
                    <div id="product-information">
                        <h1><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?></h1>
                        <p><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div id="product-price-remove">
                        <p>€ <?= $product->price ?></p>
                        <div id="actions">
                            <button class="remove" onclick="deleteListedProduct(<?= $product->id ?>)">
                                Remove <i class="fa-solid fa-trash"></i>
                            </button>
                            <button class="edit">
                                <a href="../pages/edit-listing-product.php?product_id=<?= $product->id ?>">
                                    Edit <i class="fa-solid fa-pen"></i>
                                </a>
                            </button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to remove this product?</p>
                    <button id="confirmDelete">Yes, remove it</button>
                    <button id="cancelDelete">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php function drawWishList($db, $wishList) { ?>
    <section id="wish-list">
    <h2>wishlist</h2>
        <?php foreach ($wishList as $product) { ?>
        <article>
            <img src="../database/images/<?= $product->getProductThumbnail($db) ?>">
            <div id="product-information">
                <a href="../pages/item.php?id=<?=$product->id;?>"><h1><?= htmlspecialchars($product->title, ENT_QUOTES, 'UTF-8') ?></h1></a>
                <p><?= htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div id="product-price-buy">
                <p>€ <?= $product->price ?></p>
                <div id="actions">
                    <button class="remove-wishlist" onclick="removeFromWishlist(<?= $product->id ?>)">
                        <i class="fa-solid fa-x"></i> Remove
                    </button>
                    <button class="buy" data-id="<?= $product->id ?>">
                        <a href="buy.php?product_id=<?= $product->id ?>">
                            Buy <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </button>
                </div>
            </div>
        </article>
        <?php } ?>
    </section>
<?php } ?>