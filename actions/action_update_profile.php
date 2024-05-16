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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $session->getCsrfToken()) {
            $session->addMessage('error', 'CSRF token mismatch.');
            header('Location: ../pages/index.php');
            exit();
        }

        $db = getDatabaseConnection();

        $user = User::getUserByUsername($db, $session->getUsername());
        
        if (isset($_POST['name'])) {
            $user->name = $_POST['name'];
            if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $user->name)) {
                $session->addMessage('error', 'Name can only contain letters and spaces.');
                header('Location: ../pages/account.php');
                exit();
            }
        }
        if (isset($_POST['phoneNumber'])) {
            $user->phoneNumber = $_POST['phoneNumber'];
            if (!preg_match("/^\d{9}$/", $user->phoneNumber)) {
                $session->addMessage('error', 'Phone number must be 9 digits long.');
                header('Location: ../pages/account.php');
                exit();
            }
        }
        
        $address = $user->getUserAddress($db);
        if (isset($_POST['postalCode'])) {
            $address->postalCode = $_POST['postalCode'];
            if (!preg_match("/^\d{4}-\d{3}$/", $address->postalCode)) {
                $session->addMessage('error', 'Postal Code must be in the format 1234-123.');
                header('Location: ../pages/account.php');
                exit();
            }
        }
        if (isset($_POST['address'])) {
            $address->address = $_POST['address'];
            if (!preg_match("/^(?=.*[A-Za-z])[A-Za-z0-9. ]+$/", $address->address)) {
                $session->addMessage('error', 'Address must start with a letter and can only contain letters, numbers, spaces, and points.');
                header('Location: ../pages/account.php');
                exit();
            }
        }
        if (isset($_POST['city'])) {
            $address->city = $_POST['city'];
            if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $address->city)) {
                $session->addMessage('error', 'City must start with a letter and can only contain letters and spaces and cannot be only spaces.');
                header('Location: ../pages/account.php');
                exit();
            }
        }
        if (isset($_POST['country'])) {
            $address->country = $_POST['country'];
            if (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z\s]+$/", $address->country)) {
                $session->addMessage('error', 'Country must start with a letter and can only contain letters and spaces and cannot be only spaces.');
                header('Location: ../pages/account.php');
                exit();
            }
        }

        $addressId = Address::getAddressByDetails($db, $address->postalCode, $address->address, $address->city, $address->country);
        if ($addressId === null) {
            $addressObj = new Address(0, $address->postalCode, $address->address, $address->city, $address->country);
            $addressId = $addressObj->saveToAddressTable($db);
        }

        $user->addressId = $addressId;
        $user->updateProfile($db);
        
        $session->addMessage('success', 'Profile updated!');
        header('Location: ../pages/account.php');
    }
?>