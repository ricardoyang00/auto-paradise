<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();
    $session->generateCsrfToken();

    if (!$session->isLoggedIn()) {
        header('Location: ../pages/login.php');
        exit();
    }
    
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $db = getDatabaseConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['registerUsername'];
        if (!preg_match("/^(?=.*[A-Za-z0-9])[A-Za-z0-9_]{3,20}$/", $username)) {
            $session->addMessage('error', 'Username should be 3-20 characters long, it must start with a letter and can only contain letters, numbers, and underscores.');
            header('Location: /pages/register.php');
            exit();
        }

        $name = $_POST['registerName'];
        if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $name)) {
            $session->addMessage('error', 'Name can only contain letters and spaces.');
            header('Location: /pages/register.php');
            exit();
        }
        
        $password = $_POST['registerPassword'];

        $phoneNumber = $_POST['registerPhoneNumber'];
        if (!preg_match("/^\d{9}$/", $phoneNumber)) {
            $session->addMessage('error', 'Phone number must be 9 digits long.');
            header('Location: /pages/register.php');
            exit();
        }

        $address = $_POST['registerAddress'];
        if (!preg_match("/^(?=.*[A-Za-z])[A-Za-z0-9. ]+$/", $address)) {
            $session->addMessage('error', 'Address must start with a letter and can only contain letters, numbers, spaces, and points.');
            header('Location: /pages/register.php');
            exit();
        }

        $postalCode = $_POST['registerPostalCode'];
        if (!preg_match("/^\d{4}-\d{3}$/", $postalCode)) {
            $session->addMessage('error', 'Postal Code must be in the format 1234-123.');
            header('Location: /pages/register.php');
            exit();
        }

        $city = $_POST['registerCity'];
        if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $city)) {
            $session->addMessage('error', 'City must start with a letter and can only contain letters and spaces and cannot be only spaces.');
            header('Location: /pages/register.php');
            exit();
        }

        $country = $_POST['registerCountry'];
        if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $country)) {
            $session->addMessage('error', 'Country must start with a letter and can only contain letters and spaces and cannot be only spaces.');
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