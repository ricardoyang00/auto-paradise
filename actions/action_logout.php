<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->addMessage('success', 'You have logged out!'); //not working
    $session->logout();

    header('Location: /pages/index.php');
?>