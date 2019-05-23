<?php

require_once __DIR__.'/../models/Address.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class AddressService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): AddressService {
        if (!isset(self::$instance)) {
            self::$instance = new AddressService();
        }
        return self::$instance;
    }

    public function create(Address $address): ?Address {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        address (street_address, city_name, city_code, country)
        VALUES (?, ?, ?, ?)", [
            $address->getStreetAddress(),
            $address->getCityName(),
            $address->getCityCode(),
            $address->getCountry()
            ]);
        if ($affectedRows > 0) {
            $address->setAdId($manager->lastInsertId());
            return $address;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll( 
        "SELECT 
        ad_id as adid,
        street_address as streetAddress,
        city_name as cityName,
        city_code as cityCode,
        country as country
        from
        address
        LIMIT $offset, $limit"
        );
        $addresses = [];

        foreach ($rows as $row) {
            $addresses[] = new Address($row);
        }

        return $addresses;
    }

    //Modifié le 22/05 Sacha BAILLEUL
    public function getOne(string $addressId) {
        $manager = DatabaseManager::getManager();
        $address = $manager->getOne(
            "SELECT 
        ad_id as adid,
        street_address as streetAddress,
        city_name as cityName,
        city_code as cityCode,
        country as country
        FROM
        address
        WHERE ad_id = ?"
        ,
        [$addressId]);

        if($address){
            return $address;
        }
    }
    //Fin modification

    public function update(Address $address): ?Address {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE adress
        SET street_address = ?, 
        city_name = ?, 
        city_code = ?, 
        country = ?", [
            $address->getStreetAddress(),
            $address->getCityName(),
            $address->getCityCode(),
            $address->getCountry()
            ]);
        if ($affectedRows > 0) {
            $address->setAdId($manager->lastInsertId());
            return $address;
        }
        return NULL;
    }

    public function getOne($adid) {
        $manager = DatabaseManager::getManager();
        $address = $manager->getOne(
            "SELECT 
        ad_id as adid,
        street_address as streetAddress,
        city_name as cityName,
        city_code as cityCode,
        country as country
            FROM address
            WHERE ad_id = ?", [$adid]
        );
        if ($address) {
            return new Address($address);
        }
    }



}

?>