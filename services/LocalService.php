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
        $affectedRows = $manager->exec('
        INSERT INTO
        local (name, address_ad_id)
        VALUES (?, ?)', [
        $local->getName(),
        $local->getAdId()
        ]);
        if($affectedRows > 0) {
        $local->setLoId($manager->lastInsertId());
        return $local;
        }
        return NULL;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        local'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }

}


?>