<?php

require_once __DIR__.'/../models/Affectation.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class AffectationService {

    private static $instance;

    private function __construct(){}

    public static function getInstance(): AffectationService {
        if (!isset(self::$instance)) {
            self::$instance = new AffectationService();
        }
        return self::$instance;
    }

    public function create(Affectation $affectation): ?Affectation{
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO
        service(aff_id, role, start, end,  skill_sk_id, user_u_id, service_ser_id)
        VALUES (?, ?, ?, ?, ?, ?)", [
            $affectation->getAffid(),
            $affectation->getRole(),
            $affectation->getStart(),
            $affectation->getEnd(),
            $affectation->getSkid(),
            $affectation->getUid(),
            $affectation->getSerid(),
        ]);
        if ($affectedRows > 0) {
            $affectation->setAffid($manager->lastInsertId());
            return $affectation;
        }
        return NULL;
    }


    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        aff_id as affid,
        role,
        start,
        end,
        user_u_id as uid,
        skill_sk_id as skid,
        service_ser_id as serid
        from
        affectation
        LIMIT $offset, $limit"
        );
        $affectations = [];

        foreach ($rows as $row) {
            $affectations[] = new Affectation($row);
        }

        return $affectations;
    }

    public function getAllByUser($uid, $offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT
        aff_id as affid,
        role,
        start,
        affectation.end,
        user_u_id as uid,
        skill_sk_id as skid,
        service_ser_id as serid
        FROM affectation
        WHERE  user_u_id = ? 
        LIMIT $offset, $limit",
        [$uid]
        );
        $affectations = [];

        foreach ($rows as $row) {
            $affectations[] = new Affectation($row);
        }

        return $affectations;
    }



    public function getAllByUserBetweenDates($uid, $start, $end) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT
        aff_id as affid,
        role,
        start,
        affectation.end,
        user_u_id as uid,
        skill_sk_id as skid,
        service_ser_id as serid
        FROM affectation
        WHERE  user_u_id = ? 
        AND start <= ? AND end >= ?
        ",
            [$uid, $end, $start]
        );
        $affectations = [];

        foreach ($rows as $row) {
            $affectations[] = new Affectation($row);
        }

        return $affectations;
    }

    public function getOne( $affectationId) {
        $manager = DatabaseManager::getManager();
        $affectation = $manager->getOne(
            "SELECT 
        aff_id as affid,
        role,
        start,
        end,
        user_u_id as uid,
        skill_sk_id as skid,
        service_ser_id as serid
        FROM affectation
        WHERE  aff_id= ?",
            [$affectationId]);
        if($affectation){
            return new Affectation($affectation);
        }
    }
    //Fin modification

    public function update(Affectation $affectation, $affid): ?Affectation {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE service
        SET role = ?,
        start = ?,
        end = ?,
        user_u_id  = ?,
        skill_sk_id  = ?,
        service_ser_id  = ?
        WHERE aff_id= ? ", [
            $affectation->getAffid(),
            $affectation->getRole(),
            $affectation->getStart(),
            $affectation->getEnd(),
            $affectation->getSkid(),
            $affectation->getUid(),
            $affectation->getSerid(),
            $affid
        ]);
        if ($affectedRows > 0) {
            return $affectation;
        }
        return NULL;
    }

}