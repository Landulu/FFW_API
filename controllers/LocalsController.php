<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/LocalService.php';
include_once 'services/RoomService.php';
include_once 'services/RecipeService.php';

include_once 'models/CompleteLocal.php';
include_once 'RoomsController.php';

require_once("Controller.php");


class LocalsController extends Controller {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): LocalsController {
        if(!isset(self::$controller)) {
            self::$controller = new LocalsController();
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


            $params = [];

            foreach($_GET as $key=>$value){
                if($key!="offset"&&$key!="limit"&&$key!="completeData"){
                    $params[$key]=$value;
                }
            }

            if (count($params)) {
                $locals = services\LocalService::getInstance()->getAllFiltered($offset, $limit, $params);
            } else {
                $locals = services\LocalService::getInstance()->getAll($offset, $limit);
            }

            if(isset($_GET["completeData"])){
                $methodsArr=[
                    "rooms"=>["serviceMethod"=>"getAllByLocal",
                        "completeMethods"=>[
                            "products"=>["serviceMethod"=>"getAllByRoom","completeMethods"=>[
                                "article"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getArticleId","completeMethods"=>[
                                    "ingredient"=>["serviceMethod"=>"getOne","idRelationMethod"=>"getIngredientId"]
                                ]]]]]],
                    "address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAdid"]
                ];

                $locals=parent::decorateModel($locals,$methodsArr);
//                $locals=self::decorateLocal($locals);
            }

            if($locals) {
                http_response_code(200);
                return $locals;
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
            $newLocal = services\LocalService::getInstance()->create(new Local($obj));
            if($newLocal) {
                http_response_code(201);
                return $newLocal;
            } else {
                http_response_code(400);
            }
        }
        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            $newLocal = services\LocalService::getInstance()->update(new Local($obj));
            if($newLocal) {
                http_response_code(201);
                return $newLocal;
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

            $local = services\LocalService::getInstance()->getOne($urlArray[1]);
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
            
            $rooms = services\RoomService::getInstance()->getAllByLocal($urlArray[1], $offset, $limit);
            if($rooms) {
                http_response_code(200);
                return $rooms;
            } else {
                http_response_code(400);
            }

        }


        // get room by local Id
        // locals/{loid}/recipes

        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'recipes'
            && $method == 'GET') {


            $recipes = services\RecipeService::getInstance()->getAllCookableByLocal($urlArray[1]);
            if($recipes) {
                http_response_code(200);
                return $recipes;
            } else {
                http_response_code(400);
            }

        }
    }

//    public static function decorateLocal( $locals){
//
//        $addressManager= services\AddressService::getInstance();
//        $roomManager= services\RoomService::getInstance();
//
//        $locals=json_decode(json_encode($locals),true);
//
//
//
//        foreach($locals as $key=>$local){
//            $local = new CompleteLocal($local);
//            $local->setAddress($addressManager->getOne($local->getAdid()));
//
//            $rooms=[];
//            $offset=0;
//            $limit=20;
//
//            do{
//                $newRooms = $roomManager->getAllByLocal($local->getLoid(),$offset,$limit);
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
//            $locals[$key]=$local;
//        }
//
//        return $locals;
//    }
}