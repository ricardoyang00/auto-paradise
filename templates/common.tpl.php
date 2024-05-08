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
        <script src="../javascript/images.js" defer></script>
        <script src="../javascript/wishlist.js" defer></script>
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


<!-- DEBUG FUNCTIONS -->

<?php function printAllUsers(PDO $db, string $prefix): void {
        $stmt = $db->prepare('SELECT * FROM USER');
        $stmt->execute();
    
        $output = $prefix . PHP_EOL;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output .= 'Username: ' . $row['username'] . ', Name: ' . $row['name'] . ', Phone Number: ' . $row['phone_number'] . ', Address ID: ' . $row['address_id'] . PHP_EOL;
        }
    
        $filePath = __DIR__ . '/output.txt';
        file_put_contents($filePath, $output, FILE_APPEND);
    }

    function printAllAddresses(PDO $db, string $message): void {
        $stmt = $db->query('SELECT * FROM ADDRESS');
        $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $filePath = __DIR__ . '/output.txt';
        file_put_contents($filePath, $message . PHP_EOL, FILE_APPEND);
        foreach ($addresses as $address) {
            file_put_contents($filePath, "Address ID: " . $address['address_id'] . ", Postal Code: " . $address['postal_code'] . ", Address: " . $address['address'] . ", City: " . $address['city'] . ", Country: " . $address['country'] . PHP_EOL, FILE_APPEND);
        }
    }
?>