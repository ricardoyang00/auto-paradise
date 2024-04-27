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
        $stmt = $db->prepare('SELECT * FROM BRANDS WHERE brand_id = ?');
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

?>