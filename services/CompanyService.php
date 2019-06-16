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
        $companies = [];

        foreach ($rows as $row) {
            $companies[] = new Company($row);
        }

        return $companies;
    }



    public function getAllFiltered($offset, $limit, $filters) {
        $siret = isset($filters['siret']) ? $filters['siret'] : '';
        $name = isset($filters['name']) ? $filters['name'] : '';
        $cityName = isset($filters['cityName']) ? $filters['cityName'] : '';

        $cityNameSQL = '';
        if ($cityName) {
            $cityNameSQL = " JOIN (SELECT address.ad_id FROM address WHERE  address.city_name LIKE '%{$cityName}%') AS addr
        ON addr.ad_id = company.address_ad_id ";
        }
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
        FROM company
        " .$cityNameSQL. "
        WHERE SIRET LIKE '%{$siret}%'
        and name LIKE '%{$name}%'
        LIMIT $offset, $limit"
        );
        $companies = [];

        foreach ($rows as $row) {
            $companies[] = new Company($row);
        }

        return $companies;
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

    public function getOne($companyId):?array {

        $manager = DatabaseManager::getManager();
        $company = $manager->getOne(
            "SELECT 
        co_id AS coid,
        company.SIRET as siret,
        company.status, 
        company.name, 
        company.address_ad_id AS addressId, 
        company.tel, 
        company.user_u_id AS userId 
        FROM company WHERE co_id= ? ",
            [$companyId]
        );

        return $company;
    }

}

?>