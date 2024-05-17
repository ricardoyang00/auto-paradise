<?php
    declare(strict_types=1);

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

            usort($scales, function($a, $b) {
                return strcasecmp($a->name, $b->name);
            });

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
                $scale['scale_name']
            );
        }

        public static function deleteScale(PDO $db, $scaleId): bool {
            $db->beginTransaction();
        
            try {
                $stmt = $db->prepare('DELETE FROM PRODUCT WHERE scale = ?');
                $stmt->execute([$scaleId]);
            
                $stmt = $db->prepare('DELETE FROM SCALE WHERE scale_id = ?');
                $stmt->execute([$scaleId]);
            
                $db->commit();
            
                return true;
            } catch (Exception $e) {
                $db->rollBack();
            
                return false;
            }
        }

        public static function addScale(PDO $db, string $scaleName): bool {
            $stmt = $db->prepare('INSERT INTO SCALE (scale_name) VALUES (?)');
            $result = $stmt->execute([$scaleName]);
            return $result;
        }

        public static function renameScale(PDO $db, $scaleId, $scaleName): bool {
            $stmt = $db->prepare('UPDATE SCALE SET scale_name = ? WHERE scale_id = ?');
            $result = $stmt->execute([$scaleName, $scaleId]);
            return $result;
        }
    }
?>