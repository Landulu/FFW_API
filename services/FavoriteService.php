<?php
    namespace services;
    require_once __DIR__.'/../models/Favorite.php';
    require_once __DIR__.'/../utils/database/DatabaseManager.php';
    require_once "Service.php";
    
    class FavoriteService extends Service {
    
        private static $instance;
    
        private function __construct(){}
    
        public static function getInstance(): FavoriteService {
            if (!isset(self::$instance)) {
                self::$instance = new FavoriteService();
            }
            return self::$instance;
        }
    
        public function create(\Favorite $favorite): ?\Favorite{
            $manager = \DatabaseManager::getManager();
            $affectedRows = $manager->exec(
                "INSERT INTO
            favorite(user_u_id, service_ser_id, status)
            VALUES (?, ?, ?)", [
                $favorite->getUserId(),
                $favorite->getServiceId(),
                $favorite->getStatus()
            ]);
            if($affectedRows > 0){
                $favorite->setId($manager->lastInsertId());
                return $favorite;
            }
            return NULL;
        }
    
    
        public function getAll($offset, $limit) {
            $manager = \DatabaseManager::getManager();
            $rows = $manager->getAll(
                "SELECT 
            user_u_id as userId,
            service_ser_id as serviceId,
            status
            from
            ffw.favorite LIMIT $offset, $limit");
            $favorites = [];
    
            foreach ($rows as $row) {
                $favorites[] = new \Favorite($row);
            }
            return $favorites;
        }
    
    
    
        public function getAllByUser($uid, $offset, $limit) {
            $manager = \DatabaseManager::getManager();
            $rows = $manager->getAll(
                "SELECT 
            service_ser_id as serviceId,
            user_u_id as userId,
            status
            from favorite
            WHERE user_u_id =  ?
            LIMIT $offset, $limit"
                ,
                [$uid]
            );
            $comments = [];
    
            foreach ($rows as $row) {
                $comments[] = new \Favorite($row);
            }
    
            return $comments;
        }
    
        public function update(\Favorite $favorite, $fid): ?\Favorite {
            $manager = \DatabaseManager::getManager();
            $affectedRows = $manager->exec(
                "UPDATE favorite
            SET 
            status = ?
            WHERE f_id= ? ", [
                $favorite->getStatus(),
                $fid
            ]);
            if ($affectedRows > 0) {
                return $favorite;
            }
            return NULL;
        }

        public function getOneByUidAndSid(\Favorite $favorite) {
            $manager = \DatabaseManager::getManager();
            $oldFavorite = $manager->getOne(
                " SELECT *
                FROM favorite
                WHERE user_u_id = ? AND service_ser_id = ?"
                , [$favorite->getUserId(), $favorite->getServiceId()]);
            
            if($oldFavorite) {
                return $oldFavorite;
            }
            return NULL;  
        }   

    }

?>