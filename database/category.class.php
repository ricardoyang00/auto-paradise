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
}

?>