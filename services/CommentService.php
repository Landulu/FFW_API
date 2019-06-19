<?php

namespace services;
require_once __DIR__.'/../models/Comment.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";

class CommentService extends Service {

    private static $instance;

    private function __construct(){}

    public static function getInstance(): CommentService {
        if (!isset(self::$instance)) {
            self::$instance = new CommentService();
        }
        return self::$instance;
    }

    public function create(\Comment $comment): ?\Comment{
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO
        comment(content, service_ser_id, user_u_id, status)
        VALUES (?, ?, ?, ?)", [
            $comment->getContent(),
            $comment->getServiceId(),
            $comment->getUserId(),
            $comment->getStatus()
        ]);
        if ($affectedRows > 0) {
            $comment->setCid($manager->lastInsertId());
            return $comment;
        }
        return NULL;
    }


    public function getAll($offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        c_id as cid,
        content,
        service_ser_id as serviceId,
        user_u_id as userId,
        status
        from
        ffw.comment LIMIT $offset, $limit");
        $comments = [];

        foreach ($rows as $row) {
            $comments[] = new \Comment($row);
        }
        return $comments;
    }



    public function getAllByUser($uid, $offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        c_id as cid,
        content,
        service_ser_id as serviceId,
        user_u_id as userId,
        status
        from comment
        WHERE user_u_id =  ?
        LIMIT $offset, $limit"
            ,
            [$uid]
        );
        $comments = [];

        foreach ($rows as $row) {
            $comments[] = new \Comment($row);
        }

        return $comments;
    }

    public function getAllByService($serid, $offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        c_id as cid,
        content,
        service_ser_id as serviceId,
        user_u_id as userId,
        status
        from comment
        WHERE service_ser_id =  ?
        LIMIT $offset, $limit"
            ,
            [$serid]
        );
        $comments = [];

        foreach ($rows as $row) {
            $comments[] = new \Comment($row);
        }

        return $comments;
    }


    // public function getOne( $serviceId) {
    //     $manager = \DatabaseManager::getManager();
    //     $service = $manager->getOne(
    //         "SELECT 
    //     ser_id as serid,
    //     name,
    //     description,
    //     create_time as createTime,
    //     type,
    //     capacity,
    //     is_public as isPublic,
    //     service_time as serviceTime,
    //     route_state as routeState,
    //     vehicle_v_id as vehicleId,
    //     status,
    //     is_premium as isPremium,
    //     service.local_lo_id as localId
    //     from
    //     service
    //     WHERE ser_id = ?"
    //         ,
    //         [$serviceId]);

    //     if($service){
    //         return $service;
    //     }
    // }
    //Fin modification

    public function update(\Comment $comment, $cid): ?\Comment {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE comment
        SET 
        status = ?
        WHERE c_id= ? ", [
            $service->getStatus(),
            $cid
        ]);
        if ($affectedRows > 0) {
            return $service;
        }
        return NULL;
    }


    // public function getAllByType($serviceType, $offset, $limit){
    //     $manager = \DatabaseManager::getManager();
    //     $rows = $manager->getAll(
    //         "SELECT 
    //     service.ser_id as serid,
    //     service.name,
    //     service.description,
    //     service.create_time as createTime,
    //     service.type,
    //     service.capacity,
    //     service.is_public as isPublic,
    //     service.service_time as serviceTime,
    //     service.route_state as routeState,
    //     service.vehicle_v_id as vehicleId,
    //     service.status,
    //     service.is_premium as isPremium,
    //     service.local_lo_id as localId
    //     FROM service 
    //     WHERE service.type = ?
    //     LIMIT $offset, $limit"
    //         ,
    //         [$serviceType]
    //     );
    //     $services = [];

    //     foreach ($rows as $row) {
    //         $services[] = new \Service($row);
    //     }

    //     return $services;
    // }
}
