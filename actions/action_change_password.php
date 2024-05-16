<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header('Location: /pages/login.php');
        exit();
    }

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $session->getCsrfToken()) {
            $session->addMessage('error', 'CSRF token mismatch.');
            header('Location: ../pages/index.php');
            exit();
        }

        $db = getDatabaseConnection();
        $user = User::getUserByUsername($db, $session->getUsername());

        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];
        
        if (!$user->checkPassword($oldPassword)) {
            $session->addMessage('error', 'Wrong current password!');
            header('Location: ../pages/account.php');
            exit();
        } elseif ($newPassword !== $confirmNewPassword) {
            $session->addMessage('error', 'New passwords do not match!');
            header('Location: ../pages/account.php');
            exit();
        } elseif ($oldPassword == $newPassword) {
            $session->addMessage('error', 'New password cannot be the same as the current password!');
            header('Location: ../pages/account.php');
            exit();
        } else {
            $result = $user->changePassword($db, $oldPassword, $newPassword);
    
            if ($result) {
                $session->addMessage('success', 'Password changed successfully!');
            } else {
                $session->addMessage('error', 'Failed to change password!');
            }
            header('Location: ../pages/account.php');
            exit();
        }
    }
?>