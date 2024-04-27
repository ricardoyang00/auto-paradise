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
}

?>