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

    public static function getProductsByName(PDO $db, $productName): array {
        $stmt = $db->prepare('SELECT * FROM PRODUCT WHERE title LIKE ?');
        $stmt->execute(["%$productName%"]);

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

    public static function getFilteredProducts(PDO $db, array $filters): array {
        $query = 'SELECT * FROM PRODUCT WHERE 1';
    
        $params = array();
    
        if (isset($filters['category'])) {
            $query .= ' AND category IN (' . implode(',', array_fill(0, count($filters['category']), '?')) . ')';
            $params = array_merge($params, $filters['category']);
        }
    
        if (isset($filters['brand'])) {
            $query .= ' AND brand IN (' . implode(',', array_fill(0, count($filters['brand']), '?')) . ')';
            $params = array_merge($params, $filters['brand']);
        }
    
        if (isset($filters['scale'])) {
            $query .= ' AND scale IN (' . implode(',', array_fill(0, count($filters['scale']), '?')) . ')';
            $params = array_merge($params, $filters['scale']);
        }
    
        $stmt = $db->prepare($query);
        $stmt->execute($params);
    
        $products = array();
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
}
?>
