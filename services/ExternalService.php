<?php

require_once __DIR__.'/../models/External.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

class ExternalService {

    private static $instance;

    private function __construct() { }

    public static function getInstance(): ExternalService {
        if(!isset(self::$instance)) {
        self::$instance = new ExternalService();
        }
        return self::$instance;
    }

    public function create(External $external): ?External {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        external 
        (name, tel, mail, address_ad_id)
        VALUES (?, ?, ?, ?)", [
            $external->getName(),
            $external->getTel(),
            $external->getMail(),
            $external->getAddressId()
        ]);
        if($affectedRows > 0) {
            $external->setExid($manager->lastInsertId());
        return $external;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
            ex_id as exid,
            name, 
            tel,
            mail,
            address_ad_id as addressId
            FROM external
            LIMIT $offset, $limit"
        );
        $externals = [];

        foreach ($rows as $row) {
            $externals[] = new Local($row);
        }

        return $externals;
    }

    public function getOne($exid) {
        $manager = DatabaseManager::getManager();
        $external = $manager->getOne(
            "SELECT 
            ex_id as exid,
            name, 
            tel,
            mail,
            address_ad_id as addressId
            FROM external
            WHERE ex_id = ?", [$exid]
        );
        if ($external) {
            return new External($external);
        }
    }



}


?>