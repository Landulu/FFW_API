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
        address (house_number,street_address,complement, city_name, city_code, country, latitude, longitude)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [
            $address->getHouseNumber(),
            $address->getStreetAddress(),
            $address->getComplement(),
            $address->getCityName(),
            $address->getCityCode(),
            $address->getCountry(),
            $address->getLatitude(),
            $address->getLongitude()
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
        house_number as houseNumber,
        street_address as streetAddress,
        complement,
        city_name as cityName,
        city_code as cityCode,
        country as country,
        latitude,
        longitude
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
    public function getOne( $addressId) {
        $manager = DatabaseManager::getManager();
        $address = $manager->getOne(
            "SELECT 
        ad_id as adid,
        house_number as houseNumber,
        street_address as streetAddress,
        complement,
        city_name as cityName,
        city_code as cityCode,
        country as country,
        latitude,
        longitude
        FROM
        address
        WHERE ad_id = ?"
        ,
        [$addressId]);

        if($address){
            return  new Address($address);
        }
    }
    //Fin modification

    public function update(Address $address, $adid): ?Address {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE address
        SET house_number = ?,
        street_address = ?, 
        complement = ?,
        city_name = ?, 
        city_code = ?, 
        country = ?,
        latitude = ?,
        longitude= ?
        WHERE ad_id= ? ", [
            $address->getHouseNumber(),
            $address->getStreetAddress(),
            $address->getComplement(),
            $address->getCityName(),
            $address->getCityCode(),
            $address->getCountry(),
            $address->getLatitude(),
            $address->getLongitude(),
            $adid
            ]);
        if ($affectedRows > 0) {
            return $address;
        }
        return NULL;
    }

    public function getOneByUserId( $uid) {
        $manager = DatabaseManager::getManager();
        $address = $manager->getOne(
            "SELECT 
        ad_id as adid,
        house_number as houseNumber,
        street_address as streetAddress,
        complement,
        city_name as cityName,
        city_code as cityCode,
        country as country,
        latitude,
        longitude
        FROM
        address
        JOIN user ON ad_id = user.address_ad_id AND user.u_id = ?"
            ,
            [$uid]);

        if($address){
            return $address;
        }
    }



}

?>