<?php

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class UserService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): UserService {
        if (!isset(self::$instance)) {
            self::$instance = new UserService();
        }
        return self::$instance;
    }


    public function create(User $user): ?User {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        user (email, 
            password, 
            firstname, 
            lastname,  
            last_subscription, 
            end_subscription, 
            last_edit, 
            company_name, 
            address_ad_id, 
            status, 
            tel)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getLastSubscription(),
            $user->getEndSubscription(),
            $user->getLastEdit(),
            $user->getCompanyName(),
            $user->getAddressId(),
            $user->getTel()
            ]);
        if ($affectedRows > 0) {
            $user->setUId($manager->lastInsertId());
            return $user;
        }
        return NULL;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        address'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }


    public function getOne(int $uid) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne('
        select * 
        FROM user
        WHERE u_id = ?'
        , [$uid]);
        if (sizeof($user)  > 0) {
            return $user;
        }
    }

    public function getOneByEmail(string $email) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne('
        select * 
        FROM user
        WHERE email LIKE ?'
        , ["%" . $email . "%"]);
        if (sizeof($user)  > 0) {
            return $user;
        }
    }

}

?>