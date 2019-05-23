<?php

require_once __DIR__.'/../models/Company.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class CompanyService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): CompanyService {
        if (!isset(self::$instance)) {
            self::$instance = new Company();
        }
        return self::$instance;
    }


    public function create(Company $company): ?Company {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        company 
        (SIRET, 
        status, 
        name, 
        address_ad_id,
        tel,
        user_u_id)
        VALUES (?, ?, ?, ?, ?, ?)', [
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

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        company'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }

    public function update(Company $company): ?Company {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        UPDATE company
        SET SIRET = ?, 
        status = ?, 
        name = ?, 
        address_ad_id = ?,
        tel = ?,
        user_u_id = ?', [
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

    public function getAllByUser($user_id, $offset, $limit):?array {

        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        co_id AS coid,
        company.SIRET,
        company.status, 
        company.name, 
        company.address_ad_id AS addressId, 
        company.tel, 
        company.user_u_id AS userId 
        FROM company JOIN user ON user.u_id = company.user_u_id AND user.u_id= ?
        LIMIT $offset, $limit",
            [$user_id]
        );
        foreach ($rows as $row) {
            $company[] = new Company($row);
        }
        return $company;
    }

}

?>