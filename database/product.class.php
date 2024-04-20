<?php
declare(strict_types=1);

class Product {
    public int $id;
    public int $category;
    public string $title;
    public string $description;
    public float $price;
    public string $sellerId;
    public int $brandId;
    public int $scale;

    public function __construct(int $id, int $category, string $title, string $description, float $price, string $sellerId, int $brandId, int $scale) {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->sellerId = $sellerId;
        $this->brandId = $brandId;
        $this->scale = $scale;
    }

    public static function getAllProducts(PDO $db) : array {
        $stmt = $db->query('SELECT * FROM PRODUCT');

        $products = array();
        while ($product = $stmt->fetch()) {
            $products[] = new Product(
                $product['product_id'],
                $product['category'],
                $product['title'],
                $product['description'],
                $product['price'],
                $product['seller_id'],
                $product['brand'],
                $product['scale']
            );
        }

        return $products;
    }

    public static function getProductById(PDO $db, $productId): ?Product {
        $stmt = $db->prepare('SELECT * FROM PRODUCT WHERE product_id = ?');
        $stmt->execute([$productId]);

        $product = $stmt->fetch();

        if (!$product) {
            return null;
        }

        return new Product(
            $product['product_id'],
            $product['category'],
            $product['title'],
            $product['description'],
            $product['price'],
            $product['seller_id'],
            $product['brand'],
            $product['scale']
        );
    }

    public function getCategory(PDO $db) : string {
        $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE category_id = ?');
        $stmt->execute([$this->category]);
    
        $category = $stmt->fetch();
    
        return $category['category_name'];
    }

    public function getScale(PDO $db) : string {
        $stmt = $db->prepare('SELECT * FROM SCALE WHERE scale_id = ?');
        $stmt->execute([$this->scale]);
    
        $scale = $stmt->fetch();
    
        return $scale['scale_name'];
    }

    public function getBrand(PDO $db) : string {
        $stmt = $db->prepare('SELECT * FROM BRANDS WHERE brand_id = ?');
        $stmt->execute([$this->brandId]);
    
        $brand = $stmt->fetch();
    
        return $brand['brand_name'];
    }
    
}
?>
