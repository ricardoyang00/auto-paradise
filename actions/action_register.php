<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['registerUsername'] ?? '';
        $name = $_POST['registerName'] ?? '';
        $password = $_POST['registerPassword'] ?? '';
        $phoneNumber = $_POST['registerPhoneNumber'] ?? '';
        $addressId = (int)$_POST['registerAddressId'] ?? 0;

        if (empty($username) || empty($name) || empty($password) || empty($phoneNumber) || empty($addressId)) {
            $session->addMessage('error', 'All fields are required!');
            header('Location: /pages/register.php');
            exit();
        }

        $username = strtolower($username);
        
        if (User::getUserByUsername($db, $username)) {
            $session->addMessage('error', 'Username already exists! Please choose another one.');
            header('Location: /pages/register.php');
            exit();
        }

        $hashedPassword = sha1($password);

        $user = new User($username, $name, $hashedPassword, $phoneNumber, $addressId);

        if ($user->saveToDatabase($db)) {
            $session->addMessage('success', 'Registration successful! You can now log in.');
            header('Location: /pages/login.php');
            exit();
        } else {
            $session->addMessage('error', 'Failed to register user. Please try again later.');
            header('Location: /pages/register.php');
            exit();
        }
    }
?>