<?php



require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/CompleteUser.php';
require_once __DIR__.'/../models/CompleteUser.php';
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
            $users[] = new CompleteUser($row);
        }

        return $users;
    }

    public function getAllFiltered($offset, $limit, $filters) {
        $email = isset($filters['email']) ? $filters['email'] : '';
        $firstname = isset($filters['firstname']) ? $filters['firstname'] : '';
        $lastname = isset($filters['lastname']) ? $filters['lastname'] : '';
        $skill =  isset($filters['skill']) ? $filters['skill'] : null;
        $status =  isset($filters['status']) ? $filters['status'] : null;
        $cityName = isset($filters['cityName']) ? $filters['cityName'] : null ;
        $skillSQL = '';
        $cityNameSQL = '';
        if ($skill || $status) {
            $skillCond=" user_has_skill.skill_sk_id='{$skill}'";
            $statusCond=" user_has_skill.status='{$status}'";
            $completCond=$skill&&$status?$skillCond." AND ".$statusCond : "";
            $completCond=$skill&&!$status?$skillCond:$completCond;
            $completCond=!$skill&&$status?$statusCond:$completCond;
            $skillSQL = " JOIN (SELECT DISTINCT user_has_skill.user_u_id FROM user_has_skill WHERE $completCond ) AS uhs
            ON uhs.user_u_id = user.u_id ";
        }
        if ($cityName) {
            $cityNameSQL = " JOIN (SELECT address.ad_id FROM address WHERE  address.city_name LIKE '%{$cityName}%') AS addr
        ON addr.ad_id = user.address_ad_id ";
        }
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
        user.status, 
        rights,
        tel
        FROM user
        " . $skillSQL .$cityNameSQL. "
        WHERE email LIKE '%{$email}%'
        and firstname LIKE '%{$firstname}%'
        and lastname LIKE '%{$lastname}%'
        LIMIT $offset, $limit"
        );
        $users = [];

        foreach ($rows as $row) {
            $users[] = new CompleteUser($row);
        }

        return $users;
    }


    public function getOne(int $uid) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne(
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
        WHERE u_id = ?"
        , [$uid]);
        if ($user) {
            return new CompleteUser($user);
        }
    }

    public function getOneByEmail(string $email) {
        $manager = DatabaseManager::getManager();
        $user = $manager->getOne(
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
        WHERE email = ?"
        , [$email]);
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
            tel = ? 
            WHERE user.u_id = ?", [
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
            $user->getTel(),
            $user->getUid()
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


    public function getAllBySkill(int $skid) {

    }

}

?>

