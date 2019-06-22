<?php
namespace services;
require_once __DIR__.'/../models/Article.php';
require_once __DIR__ . '/../models/CompleteProduct.php';
require_once __DIR__.'/../models/Product.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";

class ProductService extends Service {
    
    private static $instance;

    private function __construct(){}

    public static function getInstance(): ProductService {
        if (!isset(self::$instance)) {
            self::$instance = new ProductService();
        }
        return self::$instance;
    }

    public function create(\Product $product): ?\Product {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        product (
        limit_date, 
        state, 
        article_a_id, 
        product.quantity_unit , 
        product.weight_quantity , 
        basket_b_id, 
        room_r_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)", [
            $product->getLimitDate(),
            $product->getState(),
            $product->getArticleId(),
            $product->getQuantityUnit(),
            $product->getWeightQuantity(),
            $product->getBasketId(),
            $product->getRoomId()
            ]);
        if ($affectedRows > 0) {
            $product->setPrId($manager->lastInsertId());
            return $product;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT product.pr_id as prid, 
                product.limit_date as limitDate, 
                product.state as state, 
                product.article_a_id as articleId, 
                product.quantity_unit as quantityUnit, 
                product.weight_quantity as weightQuantity, 
                product.basket_b_id as basketId, 
                product.room_r_id as roomId
        FROM product
        LIMIT $offset, $limit"
        );
        $products = [];

        foreach ($rows as $row) {
            $products[] = new \Product($row);
        }
        return $products;
    }




    public function getAllByRoom($room_id, $offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT product.pr_id as prid, 
                product.limit_date as limitDate, 
                product.state as state, 
                product.article_a_id as articleId, 
                product.quantity_unit as quantityUnit, 
                product.weight_quantity as weightQuantity, 
                product.basket_b_id as basketId, 
                product.room_r_id as roomId
            FROM product
            JOIN room ON room.r_id = product.room_r_id AND room.r_id = ?
            LIMIT $offset, $limit",
            [$room_id]
            );
        $products = [];
        if($rows) {   
            foreach ($rows as $row) {
                $products[] = new \Product($row);
            }
            return $products;
        }
    }

    public function getAllByBasket($basket_b_id, $offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT product.pr_id as prid, 
                product.limit_date as limitDate, 
                product.state as state, 
                product.article_a_id as articleId, 
                product.quantity_unit as quantityUnit, 
                product.weight_quantity as weightQuantity, 
                product.basket_b_id as basketId, 
                product.room_r_id as roomId
            FROM product
            WHERE product.basket_b_id= ?
            LIMIT $offset, $limit",
            [$basket_b_id]
        );
        $products = [];
        if($rows) {
            foreach ($rows as $row) {
                $products[] = new \Product($row);
            }
            return $products;
        }
    }

    public function update(\Product $product): ?\Product {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE product
        set limit_date = ?, 
        state = ?, 
        article_a_id = ?, 
        quantity_unit = ?,
        weight_quantity=?,
        basket_b_id = ?, 
        room_r_id = ?
        WHERE pr_id =?", [
            $product->getLimitDate(),
            $product->getState(),
            $product->getArticleId(),
            $product->getQuantityUnit(),
            $product->getWeightQuantity(),
            $product->getBasketId(),
            $product->getRoomId(),
            $product->getPrid()
            ]);
        if ($affectedRows > 0) {
            return $product;
        }
        return NULL;
    }

    public function getOne(int $prid) {
        $manager = \DatabaseManager::getManager();
        $product = $manager->getOne('
        select * 
        FROM product
        WHERE pr_id = ?'
        , [$prid]);
        if ($product) {
            return $product;
        }
    }

    public function changeProductRoom($productIds, $roomId) {
        $manager = \DatabaseManager::getManager();
        $affectedRows = 0;
        $roomId=$roomId?$roomId:"NULL";
        foreach ($productIds as $key => $id) {
            
            $affectedRows += $manager->exec(
                "UPDATE product
                SET room_r_id = $roomId
                WHERE pr_id = ?",
                [
                    $id
                ]);
        }
        if ($affectedRows > 0) {
            return $affectedRows;
        }
        return NULL;
    }
    
//    public function remove($product_ids){
//        $manager = \DatabaseManager::getManager();
//        $affectedRows = 0;
//        foreach($product_ids as $key => $value){
//            $affectedRows += $manager->exec(
//            "DELETE FROM product WHERE pr_id=?
//            ", [$value]);
//        }
//        if($affectedRows>0){
//            return $affectedRows;
//        }
//    }
}


?>