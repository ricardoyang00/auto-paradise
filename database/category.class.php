<?php
declare(strict_types=1);

class Category{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getAllCategories(PDO $db) : array {
        $stmt = $db->query('SELECT * FROM CATEGORY');

        $categories = array();
        while ($category = $stmt->fetch()) {
            $categories[] = new Category(
                $category['category_id'],
                $category['category_name']
            );
        }

        return $categories;
    }

    public static function getCategoryById(PDO $db, $categoryId): ?Category {
        $stmt = $db->prepare('SELECT * FROM CATEGORY WHERE category_id = ?');
        $stmt->execute([$categoryId]);

        $category = $stmt->fetch();

        if (!$category) {
            return null;
        }

        return new Category(
            $category['category_id'],
            $category['category_name']
        );
    }

    public static function deleteCategory(PDO $db, $categoryId): bool {
        $db->beginTransaction();
    
        try {
            $stmt = $db->prepare('DELETE FROM PRODUCTS WHERE category_id = ?');
            $stmt->execute([$categoryId]);
    
            $stmt = $db->prepare('DELETE FROM CATEGORY WHERE category_id = ?');
            $stmt->execute([$categoryId]);
    
            $db->commit();
    
            return true;
        } catch (Exception $e) {
            $db->rollBack();
    
            return false;
        }
    }

    public static function addCategory(PDO $db, string $categoryName): bool {
        $stmt = $db->prepare('INSERT INTO CATEGORY (category_name) VALUES (?)');
        $result = $stmt->execute([$categoryName]);
        return $result;
    }

    public static function renameCategory(PDO $db, $categoryId, $categoryName): bool {
        $stmt = $db->prepare('UPDATE CATEGORY SET category_name = ? WHERE category_id = ?');
        $result = $stmt->execute([$categoryName, $categoryId]);
        return $result;
    }
}

?>