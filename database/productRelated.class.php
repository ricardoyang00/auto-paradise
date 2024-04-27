<?php
declare(strict_types=1);

class Brand {
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getAllBrands(PDO $db) : array {
        $stmt = $db->query('SELECT * FROM BRANDS');

        $brands = array();
        while ($brand = $stmt->fetch()) {
            $brands[] = new Brand(
                $brand['brand_id'],
                $brand['brand_name']
            );
        }

        return $brands;
    }

    public static function getBrandById(PDO $db, $brandId): ?Brand {
        $stmt = $db->prepare('SELECT * FROM BRAND WHERE brand_id = ?');
        $stmt->execute([$brandId]);

        $brand = $stmt->fetch();

        if (!$brand) {
            return null;
        }

        return new Brand(
            $brand['brand_id'],
            $brand['brand_name']
        );
    }
}

class Scale{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public static function getAllScales(PDO $db) : array {
        $stmt = $db->query('SELECT * FROM SCALE');

        $scales = array();
        while ($scale = $stmt->fetch()) {
            $scales[] = new Scale(
                $scale['scale_id'],
                $scale['scale_name']
            );
        }

        return $scales;
    }

    public static function getScaleById(PDO $db, $scaleId): ?Scale {
        $stmt = $db->prepare('SELECT * FROM SCALE WHERE scale_id = ?');
        $stmt->execute([$scaleId]);

        $scale = $stmt->fetch();

        if (!$scale) {
            return null;
        }

        return new Scale(
            $scale['scale_id'],
            $scale['category_name']
        );
    }
}

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