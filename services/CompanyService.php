<?php

require_once __DIR__.'/../models/Company.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class Company {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): Company {
        if (!isset(self::$instance)) {
            self::$instance = new Company();
        }
        return self::$instance;
    }


    public function create(Company $company): ?Company {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        company 
        (SIRET, 
        status, 
        name, 
        address_ad_id,
        tel,
        user_u_id)
        VALUES (?, ?, ?, ?, ?, ?)", [
            $company->getSiret(),
            $company->getStatus(),
            $company->getName(),
            $company->getAddressId(),
            $company->getTel(),
            $company->getUserId()
            ]);
        if ($affectedRows > 0) {
            $company->setAdId($manager->lastInsertId());
            return $company;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        co_id as coid,
        SIRET,
        status, 
        name, 
        address_ad_id as addressId,
        tel,
        user_u_id as userId 
        from company
        LIMIT $offset, $limit"
        );
        $locals = [];

        foreach ($rows as $row) {
            $locals[] = new Local($row);
        }

        return $locals;
    }

    public function update(Company $company): ?Company {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE company
        SET SIRET = ?, 
        status = ?, 
        name = ?, 
        address_ad_id = ?,
        tel = ?,
        user_u_id = ?", [
            $company->getSiret(),
            $company->getStatus(),
            $company->getName(),
            $company->getAddressId(),
            $company->getTel(),
            $company->getUserId()
            ]);
        if ($affectedRows > 0) {
            $company->setCoId($manager->lastInsertId());
            return $company;
        }
        return NULL;
    }



}

?>