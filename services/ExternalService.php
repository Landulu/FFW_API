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
        (name, tel, email, address_ad_id)
        VALUES (?, ?, ?, ?)", [
            $external->getName(),
            $external->getTel(),
            $external->getEmail(),
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
            email,
            address_ad_id as addressId
            FROM external
            LIMIT $offset, $limit"
        );
        $externals = [];

        foreach ($rows as $row) {
            $externals[] = new External($row);
        }

        return $externals;
    }

    public function getAllFiltered($offset, $limit, $filters) {
        $email = isset($filters['email']) ? $filters['email'] : '';
        $name = isset($filters['name']) ? $filters['name'] : '';
        $cityName = isset($filters['cityName']) ? $filters['cityName'] : '';

        $cityNameSQL = '';
        if ($cityName) {
                $cityNameSQL = " JOIN (SELECT address.ad_id FROM address WHERE  address.city_name LIKE '%{$cityName}%') AS addr
            ON addr.ad_id = external.address_ad_id ";
        }
        $manager = DatabaseManager::getManager();

        $rows = $manager->getAll(
            "SELECT
        ex_id as exid,
            name, 
            tel,
            email,
            address_ad_id as addressId
            FROM external
        " .$cityNameSQL. "
        WHERE IFNULL(email,'') LIKE '%{$email}%'
        and name LIKE '%{$name}%'
        LIMIT $offset, $limit"
        );
        $externals = [];

        foreach ($rows as $row) {
            $externals[] = new External($row);
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
            email,
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