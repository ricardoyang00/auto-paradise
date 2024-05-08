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

    $db = getDatabaseConnection();
    $user = User::getUserByUsername($db, $session->getUsername());

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        

        if ($user->checkPassword($oldPassword)) {
            if ($oldPassword == $newPassword) {
                $session->addMessage('error', 'New password cannot be the same as the current password!');
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $result = $user->changePassword($db, $oldPassword, $newPassword);
            
                if ($result) {
                    $session->addMessage('success', 'Password changed successfully!');
                    header('Location: ../pages/account.php');
                    exit();
                } else {
                    $session->addMessage('error', 'Failed to change password!');
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
            }
        } else {
            $session->addMessage('error', 'Wrong current password!');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
?>