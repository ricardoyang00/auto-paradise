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

    public function saveToAddressTable(PDO $db): int {
        $stmt = $db->prepare('SELECT MAX(address_id) AS max_id FROM ADDRESS');
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastId = $row['max_id'];

        $newId = $lastId + 1;

        $stmt = $db->prepare('INSERT INTO ADDRESS (address_id, postal_code, address, city, country) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$newId, $this->postalCode, $this->address, $this->city, $this->country]);

        return (int)$db->lastInsertId();
    }

    public static function getAddressById(PDO $db, int $addressId): ?Address {
        $stmt = $db->prepare('SELECT * FROM ADDRESS WHERE address_id = ?');
        $stmt->execute([$addressId]);

        $address = $stmt->fetch();

        if (!$address) {
            error_log("No address found with ID: " . $addressId);
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

    public static function getAddressByDetails(PDO $db, string $postalCode, string $address, string $city, string $country): ?int {
        $postalCode = trim($postalCode);
        $address = trim($address);
        $city = trim($city);
        $country = trim($country);

        $stmt = $db->prepare('SELECT address_id FROM ADDRESS WHERE LOWER(postal_code) = LOWER(?) AND LOWER(address) = LOWER(?) AND LOWER(city) = LOWER(?) AND LOWER(country) = LOWER(?)');
        $stmt->execute([$postalCode, $address, $city, $country]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['address_id'] : null;
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
    
        return new User(
            $user['username'],
            $user['name'],
            $user['password'],
            $user['phone_number'],
            $user['address_id']
        );
    }

    public static function getUserWithPassword(PDO $db, string $username, string $password): ?User {
        $stmt = $db->prepare('SELECT * FROM USER WHERE username = ?');
        $stmt->execute([strtolower($username)]);

        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user['password'])) {
                return new User(
                    $user['username'],
                    $user['name'],
                    $user['password'],
                    $user['phone_number'],
                    $user['address_id']
                );
            }
        }
    
        return null;
    }

    public function getUserAddress(PDO $db): ?Address {
        return Address::getAddressById($db, $this->addressId);
    }

    public function getUserWishList(PDO $db): array {
        $stmt = $db->prepare('SELECT * FROM WISHLIST WHERE user_id = ?');
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
    
    public function updateProfile(PDO $db): void {
        $fields = [];
        $values = [];

        if ($this->name !== null) {
            $fields[] = 'name = ?';
            $values[] = $this->name;
        }
        if ($this->phoneNumber !== null) {
            $fields[] = 'phone_number = ?';
            $values[] = $this->phoneNumber;
        }
        if ($this->addressId !== null) {
            $fields[] = 'address_id = ?';
            $values[] = $this->addressId;
        }

        $values[] = $this->username;

        $stmt = $db->prepare('UPDATE USER SET ' . implode(', ', $fields) . ' WHERE username = ?');
        $stmt->execute($values);
    }

    public function changePassword(PDO $db, string $oldPassword, string $newPassword): bool {
        if (!password_verify($oldPassword, $this->password)) {
            return false;
        }

        $options = ['cost' => 12];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, $options);

        $stmt = $db->prepare('UPDATE USER SET password = ? WHERE username = ?');
        $result = $stmt->execute([$hashedPassword, $this->username]);

        if ($result) {
            $this->password = $hashedPassword;
        }

        return $result;
    }

    public function checkPassword($password) {
        return password_verify($password, $this->password);
    }
} 

class Order {
    public int $orderId;
    public string $clientUsername;
    public int $productId;
    public float $totalPrice;
    public string $sellerUsername;
    public string $orderDate;
    public string $paymentMethod;
    public ?string $phoneNumber;
    public ?string $cardNumber;

    public function __construct(int $orderId, string $clientUsername, int $productId, float $totalPrice, string $sellerUsername, string $orderDate, string $paymentMethod, ?string $phoneNumber, ?string $cardNumber) {
        $this->orderId = $orderId;
        $this->clientUsername = $clientUsername;
        $this->productId = $productId;
        $this->totalPrice = $totalPrice;
        $this->sellerUsername = $sellerUsername;
        $this->orderDate = $orderDate;
        $this->paymentMethod = $paymentMethod;
        $this->phoneNumber = $phoneNumber;
        $this->cardNumber = $cardNumber;
    }

    public function saveToOrderTable(PDO $db): bool {
        $stmt = $db->prepare('INSERT INTO ORDERS (client_username, product_id, total_price, seller_username, order_date, payment_method, phone_number, card_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $result = $stmt->execute([$this->clientUsername, $this->productId, $this->totalPrice, $this->sellerUsername, $this->orderDate, $this->paymentMethod, $this->phoneNumber, $this->cardNumber]);
        return $result;
    }

    public static function getOrdersByUsername(PDO $db, string $clientUsername): array {
        $stmt = $db->prepare('SELECT * FROM ORDERS WHERE client_username = ? ORDER BY order_date DESC');
        $stmt->execute([$clientUsername]);

        $orders = [];
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = new Order(
                $order['order_id'],
                $order['client_username'],
                $order['product_id'],
                $order['total_price'],
                $order['seller_username'],
                $order['order_date'],
                $order['payment_method'],
                $order['phone_number'] ?? null,
                $order['card_number'] ?? null
            );
        }

        return $orders;
    }

    public static function getSellingsByUsername(PDO $db, string $sellerUsername): array {
        $stmt = $db->prepare('SELECT * FROM ORDERS WHERE seller_username = ? ORDER BY order_date DESC');
        $stmt->execute([$sellerUsername]);
    
        $orders = [];
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $orders[] = new Order(
                $order['order_id'],
                $order['client_username'],
                $order['product_id'],
                $order['total_price'],
                $order['seller_username'],
                $order['order_date'],
                $order['payment_method'],
                $order['phone_number'] ?? null,
                $order['card_number'] ?? null
            );
        }
    
        return $orders;
    }

    public static function getOrderById(PDO $db, int $orderId): ?Order {
        $stmt = $db->prepare('SELECT * FROM ORDERS WHERE order_id = ?');
        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            return new Order(
                $order['order_id'],
                $order['client_username'],
                $order['product_id'],
                $order['total_price'],
                $order['seller_username'],
                $order['order_date'],
                $order['payment_method'],
                $order['phone_number'] ?? null,
                $order['card_number'] ?? null
            );
        } else {
            return null;
        }
    }
} ?>

