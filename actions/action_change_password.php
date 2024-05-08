<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');
    require_once(__DIR__ . '/../templates/profile.tpl.php');

    drawHeader2();
    drawMessages($session);

    $db = getDatabaseConnection();

    $user = User::getUserByUsername($db, $session->getUsername());

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        changePassword($db, $session, $_POST, $user);
    }

    drawChangePasswordForm();
    drawFooter();
?>