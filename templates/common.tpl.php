<?php declare(strict_types = 1); ?>

<?php function drawHTMLheader() {?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Auto Paradise</title>    
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/style.css" rel="stylesheet">
        <link rel="icon" href="../images/logo/auto-paradise-icon.png" type="image/png">
        <script src="https://kit.fontawesome.com/0eb2febe39.js" crossorigin="anonymous"></script>
    </head>
<?php } ?>

<?php function drawSearchBar() {?>
    <a class="logo" href="index.php"><img src="../images/logo/auto-paradise-logo.png" height="50" alt="Auto Paradise Logo"></a>
    <form class="search-form" action="#" method="get">
    <input type="text" name="search">
    <button type="submit">Search</button>
    </form>
    <span class="user-actions">
        <section class="icons">
            <a href="#"><i class="fas fa-envelope"></i></a>
            <a href="#"><i class="fa-regular fa-heart"></i></a>
            <a href="../pages/profile.php"><i class="fa-regular fa-user"></i></a>
        </section>
        <section class="sell-button">
            <a href="../pages/sell.php">Sell now</a>
        </section>
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

<?php function drawFooter() { ?>
        </main>
        <footer>
            <p>&copy; 2024 Auto Paradise, LTW</p>
        </footer>
    </body>
</html>

<?php function drawProfile() { ?>
    <p>Profile page to do</p>
<?php } ?>

<?php } ?>

