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

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT product.pr_id as prid, 
                product.limit_date as limitdate, 
                product.state as state, 
                product.article_a_id as articleId, 
                product.basket_b_id as basketId, 
                product.room_r_id as roomId,
                article.name as articleName,
                article.category as articleCategory
        FROM product
        JOIN room ON room.r_id = product.room_r_id
        JOIN article ON article.a_id = product.article_a_id
        
        LIMIT $offset, $limit'
        );
        $products = [];

        foreach ($rows as $row) {
            $products[] = new DetailedProduct($row);
        }
        return products;
    }




    public function getAllByRoom($room_id, $offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            'SELECT product.pr_id as prid, 
                product.limit_date as limitdate, 
                product.state as state, 
                product.article_a_id as articleId, 
                product.basket_b_id as basketId, 
                product.room_r_id as roomId,
                article.name as articleName,
                article.category as articleCategory
            FROM product
            JOIN room ON room.r_id = product.room_r_id AND room.r_id = ?
            JOIN article ON article.a_id = product.article_a_id
            LIMIT $offset, $limit',
        [$room_id]);
        
        $products = [];

        foreach ($rows as $row) {
            $products[] = new DetailedProduct($row);
        }
        return products;
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