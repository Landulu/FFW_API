<?php

require_once __DIR__.'/../models/Local.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

class LocalService {

    private static $instance;

    private function __construct() { }

    public static function getInstance(): LocalService {
        if(!isset(self::$instance)) {
        self::$instance = new LocalService();
        }
        return self::$instance;
    }

    public function create(Local $local): ?Local {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        local (name, address_ad_id)
        VALUES (?, ?)", [
        $local->getName(),
        $local->getAdId()
        ]);
        if($affectedRows > 0) {
        $local->setLoId($manager->lastInsertId());
        return $local;
        }
        return NULL;
    }
    public function update(Local $local): ?Local {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE 
        local 
        SET name = ? , address_ad_id = ? 
        WHERE lo_id= ?", [
            $local->getName(),
            $local->getAdId(),
            $local->getLoId()
        ]);
        if($affectedRows > 0) {
            return $local;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
            lo_id as loid,
            name, 
            address_ad_id as adid 
            FROM local
            LIMIT $offset, $limit"
        );
        $locals = [];

        foreach ($rows as $row) {
            $locals[] = new Local($row);
        }

        return $locals;
    }

    public function getAllFiltered($offset, $limit, $filters) {
        $cityName = isset($filters['cityName']) ? $filters['cityName'] : '';
        $name = isset($filters['name']) ? $filters['name'] : '';
        if ($cityName) {
            $cityNameSQL = " JOIN (SELECT address.ad_id FROM address WHERE address.city_name LIKE '%{$cityName}%') AS addr
            ON addr.ad_id = local.address_ad_id ";
        }
        $cityNameSQL=isset($cityNameSQL) ? $cityNameSQL :'';

        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT
            lo_id as loid, 
            name, 
            address_ad_id as adid
            FROM local
            " .$cityNameSQL. "
            WHERE name LIKE '%{$name}%'
            LIMIT $offset, $limit"
        );
        $locals = [];

        foreach ($rows as $row) {
            $locals[] = new Local($row);
        }
        return $locals;
    }


    public function getOne($loid) {
        $manager = DatabaseManager::getManager();
        $local = $manager->getOne(
            "SELECT 
            lo_id as loid,
            name, 
            address_ad_id as adid 
            FROM local
            WHERE lo_id = ?", [$loid]
        );
        if ($local) {
            return new Local($local);
        }
    }

}


?>