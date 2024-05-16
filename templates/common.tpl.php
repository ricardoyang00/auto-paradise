<?php 
    declare(strict_types = 1); 
    
    require_once(__DIR__ . '/../utils/session.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/notification.class.php');
?>

<?php function drawHTMLheader($receiptPage, $scripts = []) {?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Auto Paradise</title>    
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" type="image/png" href="../images/logo/auto-paradise-icon.png">
            <link href="../css/style.css" rel="stylesheet" media="<?php echo $receiptPage ? 'screen' : 'all'; ?>">
            <?php if ($receiptPage) { ?>
                <link href="../css/print.css" media="print" rel="stylesheet">
            <?php } ?>
            <script src="https://kit.fontawesome.com/0eb2febe39.js" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
            <script src="../javascript/theme.js" defer></script>
            <script src="../javascript/wishlist.js" defer></script>
            <script src="../javascript/admin.js" defer></script>
            <?php foreach ($scripts as $script) { ?>
                <script src="../javascript/<?=$script?>.js" defer></script>
            <?php } ?>
        </head>
<?php } ?>

<?php function drawSearchBar() {
    $session = new Session();
    $numberOfUnreadNotifications = 0;
    if ($session->isLoggedIn()) {
        $username = $session->getUsername();
        $db = getDatabaseConnection();
        $numberOfUnreadNotifications = Notification::getUnreadNotificationsUser($db, $username);
    }?>
    <a class="logo" href="index.php"><img src="../images/logo/auto-paradise-logo.png" height="50" alt="Auto Paradise Logo"></a>
    <input id="search-query" type="text">
    </form>
    <span class="user-actions">
        <section class="icons">
            <a href="../pages/notifications.php" class="notification-icon">
                <i class="fa-regular fa-bell"></i>
                <?php 
                if ($numberOfUnreadNotifications > 0) { ?>
                    <span class="notification-badge"><?=$numberOfUnreadNotifications?></span>
                <?php } ?>
            </a>
            <a href="../pages/wishList.php"><i class="fa-regular fa-heart"></i></a>
            <a href="../pages/account.php"><i class="fa-regular fa-user"></i></a>
        </section>
        <section class="sell-button">
            <a href="../pages/sell.php">Sell now</a>
        </section>
        <section class="theme"><i class="fa-regular theme-selector fa-sun"></i></section>
    </span>
<?php } ?>

<?php function drawHeader($withMenu, $scripts = [], $receiptPage) { ?>
    <?=drawHTMLheader($receiptPage, $scripts)?>
    <body>
        <header>
            <?php drawSearchBar(); 
                if ($withMenu) { ?>
                    <nav id="menu">
                        <ul>
                            <li><a href="../pages/search.php">Explore</a></li>
                            <li><a href="../pages/search.php?category=3">F1</a></li>
                            <li><a href="../pages/search.php?category=2">DTM</a></li>
                            <li><a href="../pages/search.php?category=6">Le Mans</a></li>
                            <li><a href="../pages/search.php?category=all">Others</a></li>
                        </ul>
                    </nav>
            <?php } ?>
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