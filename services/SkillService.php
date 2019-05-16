<?php

require_once __DIR__.'/../models/Skill.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class SkillService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): SkillService {
        if (!isset(self::$instance)) {
            self::$instance = new SkillService();
        }
        return self::$instance;
    }


    public function create(Skill $skill): ?Skill {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        skill (name)
        VALUES (?)", [
            $skill->getName(),
            ]);
        if ($affectedRows > 0) {
            $skill->setSkId($manager->lastInsertId());
            return $skill;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        sk_id as skid,
        name
        FROM skill
        LIMIT $offset, $limit"
        );
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new Skill($row);
        }

        return $skills;
    }

    public function update(Skill $skill): ?Skill {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE skill
        SET 
        name = ?", [
            $skill->getName(),
            ]);
        if ($affectedRows > 0) {
            $skill->setSkId($manager->lastInsertId());
            return $skill;
        }
        return NULL;
    }

    public function getOne(string $skid) {
        $manager = DatabaseManager::getManager();
        $skill = $manager->getOne('
        select  
        sk_id, name
        FROM skill
        WHERE sk_id = ?'
        , [$skid]);
        if ($skill) {
            return $skill;
        }
    }

    public function getAllByUser(string $uid) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        sk.sk_id as skid,
        sk.name
        FROM skill sk
        JOIN user_has_skill uhs
        ON sk.sk_id = uhs.skill_sk_id
        WHERE uhs.user_u_id = ?",
        [$uid]
        );
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new Skill($row);
        }

        return $skills;
    }

}

?>