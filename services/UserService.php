<?php

require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../utils/DateUtil.php';
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
        $affectedRows = $manager->exec(
        "INSERT INTO
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
            rights,
            tel)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getLastSubscription(),
            $user->getEndSubscription(),
            $user->getLastEdit(),
            $user->getCompanyName(),
            $user->getAddressId(),
            $user->getStatus(),
            $user->getRights(),
            $user->getTel()
            ]);
        if ($affectedRows > 0) {
            $user->setUId($manager->lastInsertId());
            return $user;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT
        u_id as uid, 
        email, 
        password, 
        firstname, 
        lastname,  
        last_subscription as lastSubscription, 
        end_subscription as endSubscription, 
        last_edit as lastEdit, 
        company_name as companyName, 
        address_ad_id as addressId, 
        status, 
        rights,
        tel
        FROM user
        LIMIT $offset, $limit"
        );
        $users = [];

        foreach ($rows as $row) {
            $users[] = new User($row);
        }

        return $users;
    }


    public function getOne(int $uid) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne(
        "SELECT * 
        FROM user
        WHERE u_id = ?"
        , [$uid]);
        if ($user) {
            return $user;
        }
    }

    public function getOneByEmail(string $email) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne(
        "SELECT * 
        FROM user
        WHERE email LIKE ?"
        , ["%" . $email . "%"]);
        if ($user) {
            return $user;
        }
    }

    public function update(User $user): ?User {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE user
        SET email = ?, 
            password = ?, 
            firstname = ?, 
            lastname = ?,
            last_subscription = ?,
            end_subscription = ?,
            last_edit = ?,
            company_name = ?,
            address_ad_id = ?,
            status = ?,
            rights = ?,
            tel = ?", [
            $user->getEmail(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getFirstname(),
            $user->getLastname(),
            $user->getLastSubscription(),
            $user->getEndSubscription(),
            $user->getLastEdit(),
            $user->getCompanyName(),
            $user->getAddressId(),
            $user->getStatus(),
            $user->getRights(),
            $user->getTel()
            ]);
        if ($affectedRows > 0) {
            $user->setUId($manager->lastInsertId());
            return $user;
        }
        return NULL;
    }

    public function getAdherentsToday() {
        $todayDate = date("Y-m-d");
    }

}

?>