<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 23/06/19
 * Time: 18:08
 */

include_once __DIR__ . '/../services/ServiceService.php';
include_once __DIR__ . '/../services/AffectationService.php';
include_once __DIR__ . '/../services/EventService.php';
include_once __DIR__ . '/../services/AddressService.php';
require_once("Controller.php");


class EventsController extends Controller
{

    private static $controller;

    private function __construct(){}


    public static function getController(): EventsController {
        if(!isset(self::$controller)) {
            self::$controller = new EventsController();
        }
        return self::$controller;
    }

    public function processQuery($urlArray, $method){


        //get all
        /*
            /events
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;


            if(isset($_GET['name']) || isset($_GET['eventState']) || isset($_GET['createTime']) || isset($_GET['serviceTime'])){
                $events = services\EventService::getInstance()->getAllFiltered($_GET,$offset, $limit);
            }
            else{
                $events = services\EventService::getInstance()->getAll($offset, $limit);
            }

            $arrMethods=[
                "local"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getLocalId",
                    "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAdid"]]],
                "skill"=>["serviceMethod"=>"getAllByService"],
                "affectations"=>["serviceMethod"=>"getAllByService","completeMethods"=>[
                    "user"=>["objectType"=>"complete","serviceMethod"=>"getOneByAffectation"]
                ]]
            ];

            if(isset($_GET["completeData"])){
                $events=parent::decorateModel($events,$arrMethods);
            }

            if (count($events) == 0) {
                http_response_code(204);
                return [];
            } else {
                return $events;

            }
        }

    }

}