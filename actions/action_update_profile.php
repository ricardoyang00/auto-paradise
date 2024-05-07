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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = getDatabaseConnection();
        $user = User::getUserByUsername($db, $session->getUsername());
        
        if (isset($_POST['name'])) {
            $user->name = $_POST['name'];
        }
        if (isset($_POST['phoneNumber'])) {
            $user->phoneNumber = $_POST['phoneNumber'];
        }
        
        $address = $user->getUserAddress($db);
        if (isset($_POST['postalCode'])) {
            $address->postalCode = $_POST['postalCode'];
        }
        if (isset($_POST['address'])) {
            $address->address = $_POST['address'];
        }
        if (isset($_POST['city'])) {
            $address->city = $_POST['city'];
        }
        if (isset($_POST['country'])) {
            $address->country = $_POST['country'];
        }

        $addressId = Address::getAddressByDetails($db, $address->postalCode, $address->address, $address->city, $address->country);
        if ($addressId === null) {
            $addressObj = new Address(0, $address->postalCode, $address->address, $address->city, $address->country);
            $addressId = $addressObj->saveToAddressTable($db);
        }

        $user->addressId = $addressId;
        $user->updateProfile($db);
        
        $session->addMessage('success', 'Profile updated!');
        header('Location: ../pages/profile.php');
    }
?>