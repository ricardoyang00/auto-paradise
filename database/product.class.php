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

        public static function addProduct(PDO $db, $category, $title, $description, $price, $sellerId, $brandId, $scale) {
            $stmt = $db->prepare('INSERT INTO PRODUCT (category, title, description, price, seller_id, brand, scale) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$category, $title, $description, $price, $sellerId, $brandId, $scale]);

            return $db->lastInsertId();
        }

        public static function addProductImage(PDO $db, $productId, $imageUrl) {
            $stmt = $db->prepare('INSERT INTO PRODUCT_IMAGES (product_id, image_url) VALUES (?, ?)');
            $stmt->execute([$productId, $imageUrl]);
        }

        public static function getAllProducts(PDO $db): array {
            $stmt = $db->query('SELECT p.*, ps.status 
                                FROM PRODUCT p 
                                LEFT JOIN PRODUCT_STATE ps ON p.product_id = ps.product_id 
                                WHERE LOWER(ps.status) = \'available\' 
                                AND p.product_id NOT IN (SELECT product_id FROM BAN)
                                ORDER BY LOWER(p.title) ASC');
        
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
            $stmt = $db->prepare('SELECT p.*, ps.status 
                                        FROM PRODUCT p 
                                        LEFT JOIN PRODUCT_STATE ps ON p.product_id = ps.product_id 
                                        LEFT JOIN CATEGORY c ON p.category = c.category_id
                                        LEFT JOIN SCALE s ON p.scale = s.scale_id
                                        LEFT JOIN BRANDS b ON p.brand = b.brand_id
                                        WHERE (p.title LIKE ? 
                                            OR c.category_name LIKE ?
                                            OR s.scale_name LIKE ?
                                            OR b.brand_name LIKE ?)
                                            AND LOWER(ps.status) = \'available\'
                                            AND p.product_id NOT IN (SELECT product_id FROM BAN)');
            $searchTerm = "%$productName%";
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        
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
        
            usort($products, function($a, $b) {
                return strcasecmp($a->title, $b->title);
            });
        
            return $products;
        }    

        public static function getFilteredProducts(PDO $db, array $filters): array {
            $query = 'SELECT p.*, ps.status 
                FROM PRODUCT p 
                LEFT JOIN PRODUCT_STATE ps ON p.product_id = ps.product_id 
                WHERE 1';
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

            usort($products, function($a, $b) {
                return strcasecmp($a->title, $b->title);
            });
        
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
        
            return $success || $stmt->rowCount() == 0;
        }

        public static function banProduct(PDO $db, $productId, $reason) : bool {
            $stmt = $db->prepare('INSERT INTO BAN (product_id, reason) VALUES (?, ?)');
            return $stmt->execute([$productId, $reason]);
        }

        public static function unbanProduct(PDO $db, $productId) {
            $stmt = $db->prepare('DELETE FROM BAN WHERE product_id = ?');
            return $stmt->execute([$productId]);
        }

        public static function isBanned(PDO $db, $productId): bool {
            $stmt = $db->prepare('SELECT COUNT(*) FROM BAN WHERE product_id = ?');
            $stmt->execute([$productId]);

            return $stmt->fetchColumn() > 0;
        }

        public static function getBannedReason(PDO $db, $productId): ?string {
            $stmt = $db->prepare('SELECT reason FROM BAN WHERE product_id = ?');
            $stmt->execute([$productId]);

            $reason = $stmt->fetch();

            return $reason ? $reason['reason'] : null;
        }

        public static function getBannedDate(PDO $db, $productId) {
            $stmt = $db->prepare('SELECT date FROM BAN WHERE product_id = ?');
            $stmt->execute([$productId]);
            $date = $stmt->fetchColumn();
            return date('F d, Y', strtotime($date));
        }

        public static function getBannedProducts(PDO $db): array {
            $stmt = $db->query('SELECT p.*, b.reason FROM PRODUCT p INNER JOIN BAN b ON p.product_id = b.product_id');
        
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
        
        public static function addProductState(PDO $db, int $productId, string $state): bool {
            $checkStmt = $db->prepare('SELECT COUNT(*) FROM PRODUCT_STATE WHERE product_id = ?');
            $checkStmt->execute([$productId]);
            $exists = $checkStmt->fetchColumn() > 0;
        
            if (!$exists) {
                $stmt = $db->prepare('INSERT INTO PRODUCT_STATE (product_id, status) VALUES (?, ?)');
                return $stmt->execute([$productId, $state]);
            } else {
                throw new Exception("Product state for product ID $productId already exists.");
            }
        }

        public static function getProductState(PDO $db, int $productId): ?string {
            $stmt = $db->prepare('SELECT status FROM PRODUCT_STATE WHERE product_id = ?');
            $stmt->execute([$productId]);

            $state = $stmt->fetch();

            return $state ? $state['status'] : null;
        }

        public static function setProductState(PDO $db, int $productId, string $state): bool {
            $checkStmt = $db->prepare('SELECT COUNT(*) FROM PRODUCT_STATE WHERE product_id = ?');
            $checkStmt->execute([$productId]);
            $exists = $checkStmt->fetchColumn() > 0;

            if ($exists) {
                $stmt = $db->prepare('UPDATE PRODUCT_STATE SET status = ? WHERE product_id = ?');
                $result = $stmt->execute([$state, $productId]);
            } else {
                throw new Exception("Product state for product ID $productId does not exist and cannot be updated.");
            }

            return $result;
        }

        public static function getNotSoldProductsBySeller(PDO $db, string $sellerId): array {
            $stmt = $db->prepare('SELECT p.* FROM PRODUCT p INNER JOIN PRODUCT_STATE ps ON p.product_id = ps.product_id WHERE ps.status <> ? AND p.seller_id = ?');
            $stmt->execute(['Sold', $sellerId]);

            $products = [];
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

        public static function deleteProductById(PDO $db, int $productId): bool {
            $stmt = $db->prepare('DELETE FROM PRODUCT WHERE product_id = ?');
            $success = $stmt->execute([$productId]);

            return $stmt->rowCount() > 0;
        }

        public function updateProduct(PDO $db): void {
            $fields = [];
            $values = [];

            if ($this->title !== null) {
                $fields[] = 'title = ?';
                $values[] = $this->title;
            }
            if ($this->description !== null) {
                $fields[] = 'description = ?';
                $values[] = $this->description;
            }
            if ($this->category !== null) {
                $fields[] = 'category = ?';
                $values[] = $this->category;
            }
            if ($this->brandId !== null) {
                $fields[] = 'brand = ?';
                $values[] = $this->brandId;
            }
            if ($this->scale !== null) {
                $fields[] = 'scale = ?';
                $values[] = $this->scale;
            }
            if ($this->price !== null) {
                $fields[] = 'price = ?';
                $values[] = $this->price;
            }

            $values[] = $this->id;

            $stmt = $db->prepare('UPDATE PRODUCT SET ' . implode(', ', $fields) . ' WHERE product_id = ?');
            $stmt->execute($values);
        }
    }
?>


