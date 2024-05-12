<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../../utils/session.php');
    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/product.class.php');
    require_once(__DIR__ . '/../../database/user.class.php');
    require_once(__DIR__ . '/../../templates/account.tpl.php');

    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../../pages/login.php');
        exit();
    }

    $db = getDatabaseConnection();
    $username = $session->getUsername();
    $listings = Product::getNotSoldProductsBySeller($db, $username);
?>

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
    </div>
</div>