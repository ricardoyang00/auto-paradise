<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->logout();

    $session->addMessage('success', 'You have logged out!');
    header('Location: /pages/index.php');
    exit();
?>