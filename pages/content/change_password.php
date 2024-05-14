<?php
    declare (strict_types = 1);
    
    require_once(__DIR__ . '/../../utils/session.php');
    $session = new Session();

    if (!$session->isLoggedIn()) {
        header('Location: ../../pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../../database/connection.db.php');
    require_once(__DIR__ . '/../../database/user.class.php');

    $db = getDatabaseConnection();
    $user = User::getUserByUsername($db, $section->getUsername());

    drawChangePasswordForm();
?>
