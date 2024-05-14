<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: /pages/account.php');
        exit();
    }

    require_once(__DIR__ . '/../templates/account.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    
    $scripts = [];
    drawHeader(false, $scripts, false);
    drawMessages($session);
    drawRegisterForm();
    drawFooter();
?>