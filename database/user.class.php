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

    public function saveToDatabase(PDO $db): bool {
        $stmt = $db->prepare('INSERT INTO USER (username, name, password, phone_number, address_id) VALUES (?, ?, ?, ?, ?)');
        $result = $stmt->execute([$this->username, $this->name, $this->password, $this->phoneNumber, $this->addressId]);
        return $result;
    }

    public function __construct(string $username, string $name, string $password, string $phoneNumber, int $addressId) {
        $this->username = $username;
        $this->name = $name;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->addressId = $addressId;
    }

    public static function getUserByUsername(PDO $db, string $username): ?User {
        $stmt = $db->prepare('SELECT * FROM USER WHERE username = ?');
        $stmt->execute([strtolower($username)]);
    
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

    public static function getUserWithPassword(PDO $db, string $username, string $password): ?User {
        $stmt = $db->prepare('SELECT * FROM USER WHERE username = ? AND password = ?');
        $stmt->execute([strtolower($username), sha1($password)]);

        if ($user = $stmt->fetch()) {
            return new User(
                $user['username'],
                $user['name'],
                $user['password'],
                $user['phone_number'],
                $user['address_id']
            );
        } else return null;
    }

    public function getUserAddress(PDO $db): ?Address {
        return Address::getAddressById($db, $this->addressId);
    }

    public function getUserWishList(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM WISHLIST WHERE username = ?');
        $stmt->execute([$this->username]);

        $wishList = array();
        while ($product = $stmt->fetch()) {
            $wishList[] = Product::getProductById($db, $product['product_id']);
        }

        return $wishList;
    }

    public function addToWishList(PDO $db, int $productId): bool {
        $stmt = $db->prepare('INSERT INTO WISHLIST (username, product_id) VALUES (?, ?)');
        return $stmt->execute([$this->username, $productId]);
    }
    
}

?>
