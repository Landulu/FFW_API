<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

require_once 'services/ProductService.php';
include_once 'services/RoomService.php';


class RoomsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): RoomsController {
        if(!isset(self::$controller)) {
            self::$controller = new RoomsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {

        /*
        GET: '/'
        */
        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $rooms = RoomService::getInstance()->getAll($offset, $limit);
            return $rooms;
        }


        /*
        POST: '/'
        */
        //create room
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newRoom = RoomService::getInstance()->create(new Room($obj));
            if($newRoom) {
                http_response_code(201);
                return $newRoom;
            } else {
                http_response_code(400);
            }
        }


        /*
        GET: 'rooms/{int}'
        */
        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $room = RoomService::getInstance()->getOne($urlArray[1]);
            if($room) {
                http_response_code(200);
                return $room;
            } else {
                http_response_code(400);
            }
        } 


        /*
        GET: 'rooms/{int}/products'
        */
        // get products by room Id
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'products'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $products = ProductService::getInstance()->getAllByRoom($urlArray[1], $offset, $limit);
            if($products) {
                http_response_code(233);
                return $products;
            } else {
                http_response_code(400);
            }

        } 
    }
}