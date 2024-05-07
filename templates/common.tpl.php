<?php declare(strict_types = 1); ?>

<?php function drawHTMLheader() {?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Auto Paradise</title>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../images/logo/auto-paradise-icon.png">
        <link href="../css/style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/0eb2febe39.js" crossorigin="anonymous"></script>
        <script src="../javascript/theme.js" defer></script>
        <script src="../javascript/filter.js"></script>
        <script src="../javascript/notification.js"></script>
    </head>
<?php } ?>

<?php function drawSearchBar() {?>
    <a class="logo" href="index.php"><img src="../images/logo/auto-paradise-logo.png" height="50" alt="Auto Paradise Logo"></a>
    <form class="search-form" action="../pages/search.php" method="get">
        <input type="text" name="search">
        <button type="submit">Search</button>
    </form>
    <span class="user-actions">
        <section class="icons">
            <a href="#"><i class="fas fa-envelope"></i></a>
            <a href="../pages/wishList.php"><i class="fa-regular fa-heart"></i></a>
            <a href="../pages/profile.php"><i class="fa-regular fa-user"></i></a>
        </section>
        <section class="sell-button">
            <a href="../pages/sell.php">Sell now</a>
        </section>
        <section class="theme"><i class="fa-regular theme-selector fa-sun"></i></section>
    </span>
<?php } ?>

<?php function drawHeader2() { ?>
    <?=drawHTMLheader()?>
    <body>
        <header>
            <?php drawSearchBar() ?>
        </header>
        <main>
<?php } ?>

<?php function drawHeader() { ?>
    <?=drawHTMLheader()?>
    <body>
        <header>
            <?php drawSearchBar() ?>
            <nav id="menu">
                <ul>
                    <li><a href="../pages/search.php">On Sales!</a></li>
                    <li><a href="../pages/search.php">DTM</a></li>
                    <li><a href="../pages/search.php">F1</a></li>
                    <li><a href="../pages/search.php">Le Mans</a></li>
                    <li><a href="../pages/search.php">Others</a></li>
                    <li><a href="../pages/search.php">Accessories</a></li>
                </ul>
            </nav>
        </header>
        <main>
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

        <label for="registerAddressId">Address</label>
        <input type="text" id="registerAddressId" name="registerAddressId" required>

        <input type="submit" value="Register">
        <div class="account-link">
            Already have an account? <a href="profile.php">Log in</a>
        </div>
    </form>
    </div>
<?php } ?>

<?php function drawProfile($user, $address) { ?>
    <h1 id="profile-heading">Profile</h1>

<div class="profile">
    <a href="../actions/action_edit_profile.php" class="edit-icon">
        <i class="fas fa-pen"></i>
    </a>
    <div class="user-label">Username</div>
    <div class="data-container">
        <span id="username"><?=$user->username?></span>
    </div>

    <div class="user-label">Name</div>
    <div class="data-container">
        <span id="name"><?=$user->name?></span>
    </div>

    <div class="user-label">Phone Number</div>
    <div class="data-container">
        <span id="phoneNumber"><?=$user->phoneNumber?></span>
    </div>

    <?php if ($address !== null) { ?>
        <div class="user-label">Address</div>
        <div class="data-container">
            <span id="address"><?=$address->address?></span>
            <span id="postalCode"><?=$address->postalCode?></span>,
            <span id="city"><?=$address->city?></span>,
            <span id="country"><?=$address->country?></span>
        </div>
    <?php } ?>
    </div>
<?php } ?>

<?php function drawLogoutButton() { ?>
    <form action="../actions/action_logout.php" method="post">
        <button type="submit" class="logout-button">Logout</button>
    </form>
<?php } ?>

<?php function drawFooter() { ?>
        </main>
        <footer>
            <p>&copy; 2024 Auto Paradise, LTW</p>
        </footer>
    </body>
</html>
<?php } ?>

<?php function drawMessages($session) { ?>
    <section id="messages">
    <?php foreach ($session->getMessages() as $messsage) { ?>
        <article class="<?=$messsage['type']?>">
            <?=$messsage['text']?>
        </article>
    <?php } ?>
    </section>
<?php } ?>

