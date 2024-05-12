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

?>

<h2>My Listings</h2>
<div id="my-listings" class="account-content">
    <div class="listings-content">
        <article>
            <img src="../database/images/1.jpg">
            <div id="product-information">
                <h1>product bought aldasklj</h1>
                <p>some description</p>
            </div>
            <div id="product-price-edit">
                <p>€ 941,23</p>
                <div id="actions">
                    <button class="edit" data-id="product-id">Edit <i class="fa-solid fa-pen-to-square"></i></i></button>
                </div>
            </div>
        </article>
    </div>
</div>