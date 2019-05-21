<?php

require_once __DIR__.'/../models/Basket.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

class BasketService {
    
    private static $instance;

    private function __construct(){}

    public static function getInstance(): BasketService {
        if (!isset(self::$instance)) {
            self::$instance = new BasketService();
        }
        return self::$instance;
    }

    

    public function create(Basket $basket): ?Basket {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        'INSERT INTO
        basket (b_id, 
        create_time, 
        status, 
        role, 
        order, 
        service_ser_id, 
        company_co_id, 
        external_ex_id, 
        user_u_id ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $basket->getBId(),
            $basket->getCreateTime(),
            $basket->getStatus(),
            $basket->getRole(),
            $basket->getServiceId(),
            $basket->getCompanyId(),
            $basket->getExternalId(),
            $basket->getUserId()
            ]);
        if ($affectedRows > 0) {
            $basket->setBId($manager->lastInsertId());
            return $basket;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        b_id as bid,
        create_time as createTime,
        status,
        role,
        order,
        service_ser_id as serviceId,
        company_co_id as companyId,
        external_ex_id as externalId,
        user_u_id as userId
        FROM basket
        LIMIT $offset, $limit"
        );
        $baskets = [];

        foreach ($rows as $row) {
            $baskets[] = new Basket($row);
        }

        return $baskets;
    }
    
    public function getOne(int $bid) {
        $manager = DatabaseManager::getManager();
        $basket = $manager->getOne(
        "SELECT * 
        FROM basket
        WHERE b_id = ?"
        , [$bid]);
        if ($basket) {
            return $basket;
        }
    }

    public function getAllByUser($userId, $offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        b_id as bid,
        create_time as createTime,
        status,
        role,
        order,
        service_ser_id as serviceId,
        company_co_id as companyId,
        external_ex_id as externalId,
        user_u_id as userId
        FROM basket
        WHERE user_u_id
        LIMIT $offset, $limit",
        [$userId]);
        $baskets = [];

        foreach ($rows as $row) {
            $baskets[] = new Basket($row);
        }

        return $baskets;
    }


    public function getAllByStatus($status, $offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        b_id as bid,
        create_time as createTime,
        status,
        role,
        order,
        service_ser_id as serviceId,
        company_co_id as companyId,
        external_ex_id as externalId,
        user_u_id as userId
        FROM basket
        WHERE status = ?
        LIMIT $offset, $limit",
            [$status]);
        $baskets = [];

        foreach ($rows as $row) {
            $baskets[] = new Basket($row);
        }

        return $baskets;
    }

//    public function affectProductToBasket($prid, $bid) {
//        $manager = DatabaseManager::getManager();
//        $affectedRows = $manager->exec(
//        'INSERT INTO
//        basket_has_article (basket_b_id, product_pr_id)
//        VALUES (?, ?)', [
//           $bid, $prid
//            ]);
//        if ($affectedRows > 0) {
//            return 1;
//        }
//        return 0;
//    }

    // public function update(Product $product): ?Product {
    //     $manager = DatabaseManager::getManager();
    //     $affectedRows = $manager->exec('
    //     UPDATE products
    //     set limit_date = ?, 
    //     state = ?, 
    //     article_a_id = ?, 
    //     basket_b_id = ?, 
    //     room_r_id = ?)', [
    //         $product->getLimitDate(),
    //         $product->getState(),
    //         $product->getArticleId(),
    //         $product->getBasketId(),
    //         $product->getRoomId()
    //         ]);
    //     if ($affectedRows > 0) {
    //         $product->setPrId($manager->lastInsertId());
    //         return $product;
    //     }
    //     return NULL;
    // }


    // public function transferRoomForProducts($productIds, $roomId) {
    //     $manager = DatabaseManager::getManager();
    //     $affectedRows = 0;
    //     foreach ($productIds as $key => $value) {
            
    //         $affectedRows += $manager->exec('
    //             UPDATE product
    //             SET room_r_id = ?
    //             WHERE pr_id = ?',
    //             [
    //                 $roomId,
    //                 $value
    //             ]);
    //     }
    //     if ($affectedRows > 0) {
    //         return $affectedRows;
    //     }
    //     return NULL;
    // }
}


?>