<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    var_dump($_POST['loginUsername'], $_POST['loginPassword']);

    $user = User::getUserWithPassword($db, $_POST['loginUsername'], $_POST['loginPassword']);

    if ($user) {
        $session->setUsername($user->username);
        $session->addMessage('success', 'You have logged in!');
        header('Location: /pages/index.php'); // temporary jump
        exit();
    } else {
        $session->addMessage('error', 'Wrong username or password!');
        header('Location: /pages/search.php'); // temporary jump
        exit();
    }
?>