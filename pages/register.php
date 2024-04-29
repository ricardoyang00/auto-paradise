<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if ($session->isLoggedIn()) {
        header('Location: /pages/profile.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    
    drawHeader2();
    drawMessages($session);
    drawRegisterForm();
    drawFooter();
?>