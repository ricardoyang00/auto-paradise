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
    $user = User::getUserByUsername($db, $username);
    $address = Address::getAddressById($db, $user->addressId);
    $orders = Order::getOrdersByUsername($db, $username);

    drawOrders($db, $orders);
?>

