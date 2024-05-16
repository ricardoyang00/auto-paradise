<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();
    
    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();
    
    $user = User::getUserByUsername($db, $session->getUsername());
    $address = Address::getAddressById($db, $user->addressId);
    
    $isAdmin = false;
    if (User::isAdmin($db, $session->getUsername())) {
        $isAdmin = true;
    }

    $scripts = ['profile'];
    drawHeader(false, $scripts, false);
    drawMessages($session);
    drawNavBar($user, $address, $isAdmin);
    drawFooter();
?>
