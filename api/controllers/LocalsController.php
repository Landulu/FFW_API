<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/LocalService.php';
include_once 'services/RoomService.php';


class LocalsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): LocalsController {
        if(!isset(self::$controller)) {
            self::$controller = new LocalsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $locals = LocalService::getInstance()->getAll($offset, $limit);
            return $locals;
        }


        //create local
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newLocal = LocalService::getInstance()->create(new Local($obj));
            if($newLocal) {
                http_response_code(201);
                return $newLocal;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $local = LocalService::getInstance()->getOne($urlArray[1]);
            if($local) {
                http_response_code(200);
                return $local;
            } else {
                http_response_code(400);
            }
        } 

        // get room by local Id
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] = 'rooms'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $rooms = RoomService::getInstance()->getAllByLocal($urlArray[1], $offset, $limit);
            if($rooms) {
                http_response_code(200);
                return $rooms;
            } else {
                http_response_code(400);
            }

        } 
    }
}