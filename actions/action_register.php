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
        $address = $_POST['registerAddress'] ?? '';
        $postalCode = $_POST['registerPostalCode'] ?? '';
        $city = $_POST['registerCity'] ?? '';
        $country = $_POST['registerCountry'] ?? '';

        if (empty($username) || empty($name) || empty($password) || empty($phoneNumber) || 
            empty($address) || empty($postalCode) || empty($city) || empty($country)) {
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

        $addressId = Address::getAddressByDetails($db, $postalCode, $address, $city, $country);
        if ($addressId === null) {
            $addressObj = new Address(0, $postalCode, $address, $city, $country);
            $addressId = $addressObj->saveToAddressTable($db);
        }

        $options = ['cost' => 12];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT, $options);

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