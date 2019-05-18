<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/ExternalService.php';
include_once 'services/AddressService.php';
include_once 'services/BasketService.php';


class ExternalsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): ExternalsController {
        if(!isset(self::$controller)) {
            self::$controller = new ExternalsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        /*
            externals/ (GET)
        */
        if ( count($urlArray) == 1 && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $externals = ExternalsService::getInstance()->getAll($offset, $limit);
            return $externals;
        }


        //create external
        /*
            externals/ (POST)
        */
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            $newExternal = ExternalService::getInstance()->create(new External($obj));
            if($newExternal) {
                http_response_code(201);
                return $newExternal;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        /*
            external/{int} (GET)
        */
        if ( count($urlArray) == 2 
        && ctype_digit($urlArray[1]) 
        && $method == 'GET') {

            $external = ExternalService::getInstance()->getOne($urlArray[1]);
            if($external) {
                http_response_code(200);
                return $external;
            } else {
                http_response_code(400);
            }
        } 

        // get room by external Id
        // if ( count($urlArray) == 3
        // && ctype_digit($urlArray[1]) 
        // && $urlArray[2] == 'rooms'
        // && $method == 'GET') {

        //     $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
        //     $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
        //     $rooms = RoomService::getInstance()->getAllByLocal($urlArray[1], $offset, $limit);
        //     if($rooms) {
        //         http_response_code(200);
        //         return $rooms;
        //     } else {
        //         http_response_code(400);
        //     }

        // } 
    }
}