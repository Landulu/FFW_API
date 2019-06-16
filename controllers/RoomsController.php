<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

require_once 'services/ProductService.php';
include_once 'services/RoomService.php';

include_once 'models/CompleteRoom.php';

require_once("Controller.php");



class RoomsController extends Controller {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): RoomsController {
        if(!isset(self::$controller)) {
            self::$controller = new RoomsController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {

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

        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $room = RoomService::getInstance()->update(new Room($obj));

            if($room) {
                http_response_code(201);
                return $room;
            } else {
                http_response_code(400);
                return $obj;

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

            $methodsArr=
                ["article"=>[
                    "serviceMethod"=>"getOne","idRelationMethod"=>"getArticleId","completeMethods"=>[
                        "ingredient"=>["serviceMethod"=>"getOne","idRelationMethod"=>"getIngredientId"]
                    ]
                ]
                ];
            if($products) {
                http_response_code(200);
                return self::decorateModel($products,$methodsArr);
            } else {
                http_response_code(400);
            }

        } 
    }

//    public static function decorateRoom( $rooms)
//    {
//
//        $productManager = ProductService::getInstance();
//
//        $rooms = json_decode(json_encode($rooms), true);
//
//        foreach ($rooms as $key => $room) {
//            $room = new CompleteRoom($room);
//            $products=[] ;
//            $offset = 0;
//            $limit = 20;
//
//            do {
//                $newProducts=$productManager->getAllByRoom($room->getRid(), $offset, $limit);
//                if(is_array($newProducts)){
//                    $products=array_merge($products, $newProducts);
//                }
//                $offset += $limit;
//
//            } while (sizeof($products) % $limit == 0 && sizeof($products) > 0);
//
//            $room->setProducts($products);
//
//            $rooms[$key] = $room;
//        }
//        return $rooms;
//    }
}