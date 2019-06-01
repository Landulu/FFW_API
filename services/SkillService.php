<?php

require_once __DIR__.'/../models/Skill.php';
require_once __DIR__.'/../models/CompleteSkill.php';
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
        skill (name,status)
        VALUES (?,?)", [
            $skill->getName(),
            $skill->getSkStatus(),
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
        name,
        skill.status as skStatus
        FROM skill
        LIMIT $offset, $limit"
        );
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new Skill($row);
        }

        return $skills;
    }


    public function update(Skill $skill, $skid): ?Skill {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE skill
        SET 
        name = ?, 
        status = ?
        WHERE sk_id= ?", [
            $skill->getName(),
            $skill->getSkStatus(),
            $skid
            ]);
        if ($affectedRows > 0) {
            return $skill;
        }
        return NULL;
    }

    public function getOne(string $skid) {
        $manager = DatabaseManager::getManager();
        $skill = $manager->getOne('
        select  
        sk_id, name, skill.status as skStatus
        FROM skill
        WHERE sk_id = ?'
        , [$skid]);
        if ($skill) {
            return $skill;
        }
    }

    public function getAllByUser($uid,$offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        sk.sk_id as skid,
        sk.name,
        sk.status as skStatus,
        uhs.status
        FROM skill sk
        JOIN user_has_skill uhs
        ON sk.sk_id = uhs.skill_sk_id
        WHERE uhs.user_u_id = ? 
        LIMIT $offset, $limit",
        [$uid]
        );
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new CompleteSkill($row);
        }

        return $skills;
    }

    public function affectSkillToUser(string $uid, $skid, $status)
    {

        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO user_has_skill 
        VALUES(?,?,?)",
            [$uid, $skid, $status]
        );

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }

    public function updateSkillByUser(string $uid, $skid, $status)
    {

        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE user_has_skill 
        SET user_has_skill.status=? 
        WHERE user_has_skill.user_u_id=?
        AND user_has_skill.skill_sk_id=?",
            [ $status,$uid, $skid,]
        );

        if ($affectedRows > 0) {
            return true;
        }
        return false;
    }


}

?>