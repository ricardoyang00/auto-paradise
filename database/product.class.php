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
        $stmt = $db->query('SELECT * FROM PRODUCT ORDER BY LOWER(title) ASC');

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

    public static function getFilteredProducts(PDO $db, array $filters, $productName = null): array {
        $query = 'SELECT * FROM PRODUCT WHERE 1';
        $params = array();
    
        if (!empty($productName)) {
            $query .= ' AND title LIKE ?';
            $params[] = "%$productName%";
        }
    
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
    
        $query .= ' ORDER BY LOWER(title) ASC';
    
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
    

    public function getProductImages(PDO $db): array {
        $stmt = $db->prepare('SELECT image_url FROM PRODUCT_IMAGES WHERE product_id = ?');
        $stmt->execute([$this->id]);

        $images = array();
        while ($image = $stmt->fetch()) {
            $images[] = $image['image_url'];
        }

        if (count($images) == 0) {
            $images[] = 'default.png';
        }

        return $images;
    }

    public function getProductThumbnail(PDO $db): ?string {
        $stmt = $db->prepare('SELECT image_url FROM PRODUCT_IMAGES WHERE product_id = ? LIMIT 1');
        $stmt->execute([$this->id]);

        $image = $stmt->fetch();

        return $image ? $image['image_url'] : 'default.png';
    }

    public static function getUserWishList(PDO $db, $username): array {
        $stmt = $db->prepare('SELECT * FROM WISHLIST WHERE user_id = ?');
        $stmt->execute([$username]);

        $wishList = array();
        while ($product = $stmt->fetch()) {
            $wishList[] = Product::getProductById($db, $product['product_id']);
        }

        return $wishList;
    }

    public function addToWishlist(PDO $db, $username): bool {
        $stmt = $db->prepare('SELECT COUNT(*) FROM WISHLIST WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$username, $this->id]);
        $count = $stmt->fetchColumn();
    
        if ($count > 0) {
            return false;
        }
    
        $stmt = $db->prepare('INSERT INTO WISHLIST (user_id, product_id) VALUES (?, ?)');
        return $stmt->execute([$username, $this->id]);
    }

    public function removeFromWishlist(PDO $db, $username): bool {
        $stmt = $db->prepare('DELETE FROM WISHLIST WHERE user_id = ? AND product_id = ?');
        $success = $stmt->execute([$username, $this->id]);
    
        // If the deletion was successful or the product was not in the wishlist to begin with, return true
        return $success || $stmt->rowCount() == 0;
    }
    
}
?>
