<?php

namespace services;
require_once __DIR__.'/../models/Vehicle.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class VehicleService extends Service {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): VehicleService {
        if (!isset(self::$instance)) {
            self::$instance = new VehicleService();
        }
        return self::$instance;
    }


    public function create(\Vehicle $vehicle): ?\Vehicle {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        vehicle (volume, insurance_date, last_revision, description)
        VALUES (?, ?, ?, ?)", [
            $vehicle->getVolume(),
            $vehicle->getInsuranceDate(),
            $vehicle->getLastRevision(),
            $vehicle->getDescription()
            ]);
        if ($affectedRows > 0) {
            $vehicle->setVId($manager->lastInsertId());
            return $vehicle;
        }
        return NULL;
    }

    public function getAll($offset,$limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        v_id as vid, 
        volume, 
        insurance_date as insuranceDate,
        last_revision as lastRevision,
        description 
        FROM vehicle
        LIMIT $offset, $limit"
        );
        $vehicles = [];

        foreach ($rows as $row) {
            $vehicles[] = new \Vehicle($row);
        }

        return $vehicles;
    }

    public function getAllFiltered($offset,$limit,$params) {

        $manager = \DatabaseManager::getManager();

        $finalSql=null;

        if(isset($params['description'])){ $sqlArr["descriptionSql"] = " description LIKE '%{$params["description"]}%'"; }
        if(isset($params['volume'])){ $sqlArr["volumeSql"] = " volume = '{$params["volume"]}'"; }
        if(isset($params['insuranceDate'])){ $sqlArr["insuranceDateSql"] = " insurance_date = '{$params["insuranceDate"]}'"; }
        if(isset($params['lastRevision'])){ $sqlArr["lastRevisionSql"] = " last_revision = '{$params["lastRevision"]}'"; }

        $finalSql=parent::getAndSql($sqlArr);

        $rows = $manager->getAll(
            "SELECT 
        v_id as vid, 
        volume, 
        insurance_date as insuranceDate,
        last_revision as lastRevision,
        description 
        FROM vehicle
        WHERE $finalSql
        LIMIT $offset, $limit"
        );

        $vehicles = [];

        foreach ($rows as $row) {
            $vehicles[] = new \Vehicle($row);
        }

        return $vehicles;
    }

    public function getOne($vid) {
        $manager = \DatabaseManager::getManager();
        $vehicle = $manager->getOne(
            "SELECT 
        v_id as vid, 
        volume, 
        insurance_date as insuranceDate,
        last_revision as lastRevision,
        description 
        FROM vehicle
        WHERE v_id=?",[$vid]
        );

        if($vehicle){
            return new \Vehicle($vehicle);
        }
        return null;
    }
}

?>