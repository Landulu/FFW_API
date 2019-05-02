<?php

require_once __DIR__.'/../models/Vehicle.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class VehicleService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): VehicleService {
        if (!isset(self::$instance)) {
            self::$instance = new VehicleService();
        }
        return self::$instance;
    }


    public function create(Vehicle $vehicle): ?Vehicle {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        vehicle (volume, insurance_date, last_revision, description)
        VALUES (?, ?, ?, ?)', [
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

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        'SELECT 
        v_id as vid, 
        volume, 
        insurance_date as insuranceDate,
        last_revision as lastRevision,
        description 
        FROM vehicle
        LIMIT $offset, $limit'
        );
        $vehicles = [];

        foreach ($rows as $row) {
            $vehicles[] = new Vehicle($row);
        }

        return $vehicles;
    }

}

?>