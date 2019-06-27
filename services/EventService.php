<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 23/06/19
 * Time: 18:26
 */

namespace services;
require_once __DIR__.'/../models/Service.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class EventService extends Service
{

    private static $instance;

    private function __construct(){}

    public static function getInstance(): EventService {
        if (!isset(self::$instance)) {
            self::$instance = new EventService();
        }
        return self::$instance;
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
        duration as duration,
        service_end as serviceEnd,
        route_state as routeState,
        vehicle_v_id as vehicleId,
        status,
        is_premium as isPremium,
        local_lo_id as localId
        from
        service WHERE service.type = 'event'
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
        if(isset($params['eventState'])){ $sqlArr["eventStateSql"] = " status = '{$params["eventState"]}'"; }
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
        service.duration as duration,
        service.service_end as serviceEnd,
        service.route_state as routeState,
        service.vehicle_v_id as vehicleId,
        service.status,
        service.is_premium as isPremium,
        service.local_lo_id as localId
        FROM service 
        WHERE service.type='event' AND  $finalSql
        LIMIT $offset,$limit");

        $services = [];

        foreach ($rows as $row) {
            $services[] = new \Service($row);
        }

        return $services;
    }


}