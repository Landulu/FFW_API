<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/VehicleService.php';


require_once("Controller.php");


class VehiclesController extends Controller {


    private static $controller;

    private function __construct(){}

    
    public static function getController(): VehiclesController {
        if(!isset(self::$controller)) {
            self::$controller = new VehiclesController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {


        //get all
        /*
            locals/ (GET)
        */
        if ( count($urlArray) == 1 && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $vehicles = services\VehicleService::getInstance()->getAll($offset, $limit);

            if($vehicles) {
                http_response_code(200);
                return $vehicles;
            } else {
                http_response_code(400);
            }
        }


        //create local
        /*
            locals/ (POST)
        */
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            $newVehicle = services\VehicleService::getInstance()->create(new Vehicle($obj));
            if($newVehicle) {
                http_response_code(201);
                return $newVehicle;
            } else {
                http_response_code(400);
            }
        }
        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            $newVehicle = services\VehicleService::getInstance()->update(new Vehicle($obj));
            if($newVehicle) {
                http_response_code(201);
                return $newVehicle;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        /*
            locals/{int} (GET)
        */
        if ( count($urlArray) == 2 
        && ctype_digit($urlArray[1]) 
        && $method == 'GET') {

            $local = services\VehicleService::getInstance()->getOne($urlArray[1]);
            if($local) {
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        } 

        // get room by local Id
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'rooms'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $rooms = services\RoomService::getInstance()->getAllByVehicle($urlArray[1], $offset, $limit);
            if($rooms) {
                http_response_code(200);
                return $rooms;
            } else {
                http_response_code(400);
            }

        } 
    }

//    public static function decorateVehicle( $vehicles){
//
//        $addressManager= services\AddressService::getInstance();
//        $roomManager= services\RoomService::getInstance();
//
//        $vehicles=json_decode(json_encode($vehicles),true);
//
//
//
//        foreach($vehicles as $key=>$local){
//            $local = new CompleteVehicle($local);
//            $local->setAddress($addressManager->getOne($local->getAdid()));
//
//            $rooms=[];
//            $offset=0;
//            $limit=20;
//
//            do{
//                $newRooms = $roomManager->getAllByVehicle($local->getLoid(),$offset,$limit);
//                if(is_array($newRooms)){
//                    $rooms=array_merge($rooms,$newRooms);
//                }
//                $offset+=$limit;
//
//            }while(sizeof($rooms)%$limit==0 && sizeof($rooms)>0);
//
//            $rooms=RoomsController::decorateRoom($rooms);
//
//            $local->setAddress($addressManager->getOne($local->getAdid()));
//            $local->setRooms($rooms);
//
//            $vehicles[$key]=$local;
//        }
//
//        return $vehicles;
//    }
}