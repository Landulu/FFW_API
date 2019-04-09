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

    public function getALl() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * FROM product');
        if (sizeof($rows) > 0) {
            return $rows;
        }
    }


    public function getAllByRoom($room_id) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT product.pr_id, product.limit_date, product.state, product.article_a_id, product.basket_b_id, product.room_r_id FROM product
        JOIN room ON room.r_id = product.room_r_id AND room.r_id = ?',
        [$room_id]
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }
}


?>