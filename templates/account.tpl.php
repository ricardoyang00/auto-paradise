<?php

declare(strict_types = 1);

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
        <div class="icon-and-button">
            <a href="#" class="change-password-icon"><i class="fa-solid fa-lock"></i></a>
            <form action="../actions/action_logout.php" method="post">
                <button type="submit" class="profile-button" id="logout">Logout</button>
            </form>
        </div>
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

<?php function drawTransactions($db, $transactions, $type) {
    $title = $type === 'orders' ? 'My Orders' : 'My Solds';
    $divId = $type === 'orders' ? 'my-orders' : 'my-solds'; ?>
    <h2><?= $title ?></h2>
    <div id="<?= $divId ?>" class="account-content">
        <div class="<?= $type ?>-content">
            <?php foreach ($transactions as $transaction):
                $product = Product::getProductById($db, $transaction->productId);
                $thumbnail = $product->getProductThumbnail($db); ?>
                <article>
                    <img src="../database/images/<?= $thumbnail ?>">
                    <div id="product-information">
                        <h1><?= $product->title ?></h1>
                        <p><?= $product->description ?></p>
                        <p><?= $transaction->orderDate ?></p>
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

<?php function drawListings($db, $listings) { ?>
    <h2>My Listings</h2>
    <div id="my-listings" class="account-content">
        <div class="listings-content">
            <?php foreach ($listings as $product):
                $thumbnail = $product->getProductThumbnail($db); ?>
                <article>
                    <img src="../database/images/<?= $thumbnail ?>">
                    <div id="product-information">
                        <h1><?= $product->title ?></h1>
                        <p><?= $product->description ?></p>
                    </div>
                    <div id="product-price-remove">
                        <p>€ <?= $product->price ?></p>
                        <div id="actions">
                            <button class="remove" onclick="deleteListedProduct(<?= $product->id ?>)">
                                Remove <i class="fa-solid fa-trash"></i>
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