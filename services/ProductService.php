<?php

require_once __DIR__.'/../models/Article.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

class ProductService {
    
    private static $instance;

    private function __construct(){}

    public static function getInstance(): ProductService {
        if (!isset(self::$instance)) {
            self::$instance = new ProductService();
        }
        return self::$instance;
    }

    public function create(Product $product): ?Product {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        product (limit_date, state, article_a_id, basket_b_id, room_r_id)
        VALUES (?, ?, ?, ?)', [
            $product->getLimitDate(),
            $product->getState(),
            $product->getArticleId(),
            $product->getBasketId(),
            $product->getRoomId()
            ]);
        if ($affectedRows > 0) {
            $product->setVId($manager->lastInsertId());
            return $product;
        }
        return NULL;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT product.pr_id, 
        product.limit_date, 
        product.state, 
        product.article_a_id, 
        product.basket_b_id, 
        product.room_r_id,
        article.name,
        article.category
        FROM product
        JOIN room ON room.r_id = product.room_r_id
        JOIN article ON article.a_id = product.article_a_id');
        if (sizeof($rows) > 0) {
            return $rows;
        }
    }


    public function getAllByRoom($room_id) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT product.pr_id, 
            product.limit_date, 
            product.state, 
            product.article_a_id, 
            product.basket_b_id, 
            product.room_r_id,
            article.name,
            article.category
        FROM product
        JOIN room ON room.r_id = product.room_r_id AND room.r_id = ?
        JOIN article ON article.a_id = product.article_a_id',
        [$room_id]);
        if (sizeof($rows)  > 0) {
            return $rows;
        }
        return NULL;
    }

    public function update(Product $product): ?Product {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        UPDATE products
        set limit_date = ?, 
        state = ?, 
        article_a_id = ?, 
        basket_b_id = ?, 
        room_r_id = ?)', [
            $product->getLimitDate(),
            $product->getState(),
            $product->getArticleId(),
            $product->getBasketId(),
            $product->getRoomId()
            ]);
        if ($affectedRows > 0) {
            $product->setPrId($manager->lastInsertId());
            return $product;
        }
        return NULL;
    }

    public function getOne(int $prid) {
        $manager = DatabaseManager::getManager();
        $product = $manager->getOne('
        select * 
        FROM product
        WHERE pr_id = ?'
        , [$prid]);
        if (sizeof($product)  > 0) {
            return $product;
        }
    }

    public function transferRoomForProducts($productIds, $roomId) {
        $manager = DatabaseManager::getManager();
        $affectedRows = 0;
        foreach ($productIds as $key => $value) {
            
            $affectedRows += $manager->exec('
                UPDATE product
                SET room_r_id = ?
                WHERE pr_id = ?',
                [
                    $roomId,
                    $value
                ]);
        }
        if ($affectedRows > 0) {
            return $affectedRows;
        }
        return NULL;
    }
    
    public function remove($product_ids){
        $manager = DatabaseManager::getManager();
        $affectedRows = 0;
        foreach($product_ids as $key => $value){
            $affectedRows += $manager->exec('
            DELETE FROM product WHERE pr_id=?
            ', [$value]);
        }
        if($affectedRows>0){
            return $affectedRows;
        }
    }
}


?>