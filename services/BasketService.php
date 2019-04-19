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
        $affectedRows = $manager->exec('
        INSERT INTO
        basket (b_id, create_time, validation_status, role, processed, order, service_ser_id, company_co_id, external_ex_id, user_u_id )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $basket->getBId(),
            $basket->getCreateTime(),
            $basket->getValidationStatus(),
            $basket->getRole(),
            $basket->getProcessed(),
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

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            'SELECT *
        FROM basket'
        );
        if (sizeof($rows) > 0) {
            return $rows;
        }
    }
    
    public function getOne(int $bid) {
        $manager = DatabaseManager::getManager();
        $basket = $manager->getOne('
        select * 
        FROM basket
        WHERE b_id = ?'
        , [$bid]);
        if (sizeof($basket)  > 0) {
            return $basket;
        }
    }

    public function getAllByUser($userId) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        'SELECT *
        FROM product
        WHERE user_u_id',
        [$userId]);
        if (sizeof($rows)  > 0) {
            return $rows;
        }
        return NULL;
    }

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