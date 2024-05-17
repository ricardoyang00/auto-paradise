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

            usort($brands, function($a, $b) {
                if ($a->name === 'Other') {
                    return 1;
                } elseif ($b->name === 'Other') {
                    return -1;
                } else {
                    return strcasecmp($a->name, $b->name);
                }
            });

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

        public static function deleteBrand(PDO $db, $brandId): bool {
            $db->beginTransaction();
        
            try {
                $stmt = $db->prepare('DELETE FROM PRODUCT WHERE brand = ?');
                $stmt->execute([$brandId]);
            
                $stmt = $db->prepare('DELETE FROM BRANDS WHERE brand_id = ?');
                $stmt->execute([$brandId]);
            
                $db->commit();
            
                return true;
            } catch (Exception $e) {
                $db->rollBack();
            
                return false;
            }
        }

        public static function addBrand(PDO $db, string $brandName): bool {
            $stmt = $db->prepare('INSERT INTO BRANDS (brand_name) VALUES (?)');
            $result = $stmt->execute([$brandName]);
            return $result;
        }

        public static function renameBrand(PDO $db, $brandId, $brandName): bool {
            $stmt = $db->prepare('UPDATE BRANDS SET brand_name = ? WHERE brand_id = ?');
            $result = $stmt->execute([$brandName, $brandId]);
            return $result;
        }
    }
?>