<?php
declare(strict_types=1);

class Product
{
    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public int $sellerId;
    public int $brandId;

    public function __construct(int $id, string $title, string $description, float $price, int $sellerId, int $brandId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->sellerId = $sellerId;
        $this->brandId = $brandId;
    }

    public static function getAllProducts(PDO $db) : array
    {
        $stmt = $db->query('SELECT product_id, title, description, price, seller_id, brand FROM PRODUCT');

        $products = array();
        while ($product = $stmt->fetch()) {
            $products[] = new Product(
                $product['product_id'],
                $product['title'],
                $product['description'],
                $product['price'],
                intval($product['seller_id']),
                $product['brand']
            );
        }

        return $products;
    }

    public static function getProducts(PDO $db, int $count) : array
    {
        $stmt = $db->prepare('SELECT product_id, title, description, price, seller_id, brand FROM PRODUCT LIMIT ?');
        $stmt->execute(array($count));

        $products = array();
        while ($product = $stmt->fetch()) {
            $products[] = new Product(
                $product['product_id'],
                $product['title'],
                $product['description'],
                $product['price'],
                $product['seller_id'],
                $product['brand']
            );
        }

        return $products;
    }

    public static function searchProducts(PDO $db, string $search, int $count) : array
    {
        $stmt = $db->prepare('SELECT product_id, title, description, price, seller_id, brand FROM PRODUCT WHERE title LIKE ? LIMIT ?');
        $stmt->execute(array($search . '%', $count));

        $products = array();
        while ($product = $stmt->fetch()) {
            $products[] = new Product(
                $product['product_id'],
                $product['title'],
                $product['description'],
                $product['price'],
                $product['seller_id'],
                $product['brand']
            );
        }

        return $products;
    }

    public static function getProduct(PDO $db, int $id) : Product
    {
        $stmt = $db->prepare('SELECT product_id, title, description, price, seller_id, brand FROM PRODUCT WHERE product_id = ?');
        $stmt->execute(array($id));

        $product = $stmt->fetch();

        return new Product(
            $product['product_id'],
            $product['title'],
            $product['description'],
            $product['price'],
            $product['seller_id'],
            $product['brand']
        );
    }
}
?>
