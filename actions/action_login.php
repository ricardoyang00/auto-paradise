<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['loginUsername'] ?? '';
        $password = $_POST['loginPassword'] ?? '';

        if (empty($username) || empty($password)) {
            $session->addMessage('error', 'Username and password are required!');
            header('Location: /pages/login.php');
            exit();
        }

        $user = User::getUserWithPassword($db, $username, $password);

        if ($user) {
            $session->setUsername($user->username);
            $session->addMessage('success', 'You have logged in!');
            header('Location: /pages/index.php');
            exit();
        } else {
            $session->addMessage('error', 'Wrong username or password!');
            header('Location: /pages/login.php');
            exit();
        }
    }
?>