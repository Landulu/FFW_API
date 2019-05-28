<?php

require_once __DIR__.'/../models/Company.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class CompanyService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): CompanyService {
        if (!isset(self::$instance)) {
            self::$instance = new CompanyService();
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
            $company->setCoId($manager->lastInsertId());
            return $company;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        co_id as coid,
        SIRET as siret,
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

    public function update(Company $company, $coid): ?Company {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE company
        SET SIRET = ?, 
        status = ?, 
        name = ?, 
        address_ad_id = ?,
        tel = ?,
        user_u_id = ?
        WHERE co_id=?", [
            $company->getSiret(),
            $company->getStatus(),
            $company->getName(),
            $company->getAddressId(),
            $company->getTel(),
            $company->getUserId(),
            $coid
            ]);
        if ($affectedRows > 0) {
            return $company;
        }
        return NULL;
    }

    public function getAllByUser($user_id, $offset, $limit):?array {

        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        co_id AS coid,
        company.SIRET as siret,
        company.status, 
        company.name, 
        company.address_ad_id AS addressId, 
        company.tel, 
        company.user_u_id AS userId 
        FROM company JOIN user ON user.u_id = company.user_u_id AND user.u_id= ?
        LIMIT $offset, $limit",
            [$user_id]
        );
        if(isset($rows)&&!empty($rows)){
            foreach ($rows as $row) {
                $company[] = new Company($row);
            }
            return $company;
        }
        return null;

    }

}

?>