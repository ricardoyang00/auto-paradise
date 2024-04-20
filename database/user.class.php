<?php
declare(strict_types=1);

class Address {
    public int $addressId;
    public string $postalCode;
    public string $address;
    public string $city;
    public string $country;

    public function __construct(int $addressId, string $postalCode, string $address, string $city, string $country) {
        $this->addressId = $addressId;
        $this->postalCode = $postalCode;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
    }

    public static function getAddressById(PDO $db, int $addressId): ?Address {
        $stmt = $db->prepare('SELECT * FROM ADDRESS WHERE address_id = ?');
        $stmt->execute([$addressId]);

        $address = $stmt->fetch();

        if (!$address) {
            return null;
        }

        return new Address(
            $address['address_id'],
            $address['postal_code'],
            $address['address'],
            $address['city'],
            $address['country']
        );
    }
}

class User {
    public string $username;
    public string $name;
    private string $password;
    public string $phoneNumber;
    public int $addressId;

    public function __construct(string $username, string $name, string $password, string $phoneNumber, int $addressId) {
        $this->username = $username;
        $this->name = $name;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->addressId = $addressId;
    }

    public static function getUserByUsername(PDO $db, string $username): ?User {
        $stmt = $db->prepare('SELECT * FROM USER WHERE username = ?');
        $stmt->execute([$username]);
    
        $user = $stmt->fetch();
    
        if (!$user) {
            return null;
        }
    
        $userInstance = new User(
            $user['username'],
            $user['name'],
            $user['password'],
            $user['phone_number'],
            $user['address_id']
        );
    
        $userInstance->password = $user['password'];
    
        return $userInstance;
    }

    public function getUserAddress(PDO $db): ?Address {
        return Address::getAddressById($db, $this->addressId);
    }
    
}

?>
