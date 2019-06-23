<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 27/05/19
 * Time: 17:08
 */
namespace services;
require_once __DIR__.'/../models/Service.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class CourseService extends Service {

    private static $instance;

    private function __construct(){}

    public static function getInstance(): CourseService {
        if (!isset(self::$instance)) {
            self::$instance = new CourseService();
        }
        return self::$instance;
    }

    public function create(\Service $service): ?\Service{

        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO
        service(name, description, create_time, type, capacity, is_public, service_time, service_end, route_state, vehicle_v_id, status, is_premium,local_lo_id)
        VALUES (?, ?, now(), ?, ?, ?, ?, ?, ?, ?, ?,?,?)", [
            $service->getName(),
            $service->getDescription(),
            $service->getType(),
            $service->getCapacity(),
            $service->getisPublic(),
            $service->getServiceTime(),
            $service->getServiceEnd(),
            $service->getRouteState(),
            $service->getVehicleId(),
            $service->getStatus(),
            $service->getisPremium(),
            $service->getLocalId()
        ]);
        if ($affectedRows > 0) {
            $service->setSerid($manager->lastInsertId());
            return $service;
        }
        return NULL;
    }


    public function getAll($offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        ser_id as serid,
        name,
        description,
        create_time as createTime,
        type,
        capacity,
        is_public as isPublic,
        service_time as serviceTime,
        service_end as serviceEnd,
        route_state as routeState,
        vehicle_v_id as vehicleId,
        status,
        is_premium as isPremium,
        local_lo_id as localId
        from
        service WHERE service.type = 'course'
        LIMIT $offset, $limit
        "
        );
        $services = [];

        foreach ($rows as $row) {
            $services[] = new \Service($row);
        }
        return $services;
    }


    public function getAllFiltered($params, $offset, $limit) {

        $manager = \DatabaseManager::getManager();
        $sqlArr=[];
        $finalSql=null;

        if(isset($params['name'])){ $sqlArr["nameSql"] = " name  LIKE '%{$params["name"]}%'"; }
        if(isset($params['routeState'])){ $sqlArr["routeStateSql"] = " status = '{$params["routeState"]}'"; }
        if(isset($params['vehicleId'])){ $sqlArr["vehicleIdSql"] = " vehicle_v_id = ".$params["vehicleId"]; }
        if(isset($params['createTime'])){ $sqlArr["createTimeSql"] = "DATE(create_time)= '{$params["createTime"]}'"; }
        if(isset($params['serviceTime'])){ $sqlArr["serviceTimeSql"] = " DATE(service_time)= '{$params["serviceTime"]}'"; }

        $finalSql=parent::getAndSql($sqlArr);

        $rows = $manager->getAll(
            "SELECT 
        service.ser_id as serid,
        service.name,
        service.description,
        service.create_time as createTime,
        service.type,
        service.capacity,
        service.is_public as isPublic,
        service.service_time as serviceTime,
        service.service_end as serviceEnd,
        service.route_state as routeState,
        service.vehicle_v_id as vehicleId,
        service.status,
        service.is_premium as isPremium,
        service.local_lo_id as localId
        FROM service 
        WHERE service.type='course' AND  $finalSql
        LIMIT $offset,$limit");

        $services = [];

        foreach ($rows as $row) {
            $services[] = new \Service($row);
        }

        return $services;
    }



    public function getAllByUser($uid, $offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        service.ser_id as serid,
        service.name,
        service.description,
        service.create_time as createTime,
        service.type,
        service.capacity,
        service.is_public as isPublic,
        service.service_time as serviceTime,
        service.service_end as serviceEnd,
        service.route_state as routeState,
        service.vehicle_v_id as vehicleId,
        service.status,
        service.is_premium as isPremium,
        service.local_lo_id as localId
        FROM service 
        JOIN affectation on service.ser_id=affection.service_ser_id AND affectation.user_u_id= ? AND service.type = 'course'
        LIMIT $offset, $limit"
            ,
            [$uid]
        );
        $courses = [];

        foreach ($rows as $row) {
            $courses[] = new \Service($row);
        }

        return $courses;
    }


    public function getOne( $serviceId) {
        $manager = \DatabaseManager::getManager();
        $service = $manager->getOne(
            "SELECT 
        ser_id as serid,
        name,
        description,
        create_time as createTime,
        type,
        capacity,
        is_public as isPublic,
        service_time as serviceTime,
        service_end as serviceEnd,
        route_state as routeState,
        vehicle_v_id as vehicleId,
        status,
        is_premium as isPremium,
        service.local_lo_id as localId
        from
        service
        WHERE ser_id = ? AND type = 'course'"
            ,
            [$serviceId]);

        if($service){
            return new \Service($service);
        }
    }
    //Fin modification

    public function update(\Service $service, $serid): ?\Service {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE service
        SET name = ?,
        description = ?,
        create_time  = ?,
        type = ?,
        capacity = ?,
        is_public  = ?,
        service_time  = ?,
        service_end = ?,
        route_state  = ?,
        vehicle_v_id  = ?,
        status = ?,
        is_premium = ?,
        local_lo_id= ?
        WHERE ser_id= ? ", [
            $service->getName(),
            $service->getDescription(),
            $service->getCreateTime(),
            $service->getType(),
            $service->getCapacity(),
            $service->getisPublic(),
            $service->getServiceTime(),
            $service->getServiceEnd(),
            $service->getRouteState(),
            $service->getVehicleId(),
            $service->getStatus(),
            $service->getisPremium(),
            $service->getLocalId(),
            $serid
        ]);
        if ($affectedRows > 0) {
            return $service;
        }
        return NULL;
    }


//
//    public function getOneByUserId( $uid) {
//        $manager = \DatabaseManager::getManager();
//        $address = $manager->getOne(
//            "SELECT
//        ad_id as adid,
//        house_number as houseNumber,
//        street_address as streetAddress,
//        complement,
//        city_name as cityName,
//        city_code as cityCode,
//        country as country,
//        latitude,
//        longitude
//        FROM
//        address
//        JOIN user ON ad_id = user.address_ad_id AND user.u_id = ?"
//            ,
//            [$uid]);
//
//        if($address){
//            return $address;
//        }
//    }





}