<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/BasketService.php';


class BasketsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): BasketsController {
        if(!isset(self::$controller)) {
            self::$controller = new BasketsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $baskets = Basketservice::getInstance()->getAll($offset, $limit);
            return $baskets;
        }


        //create basket
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newArticle = Basketservice::getInstance()->create(new Article($obj));
            if($newArticle) {
                http_response_code(201);
                return $newArticle;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $article = Basketservice::getInstance()->getOne($urlArray[1]);
            if($article) {
                http_response_code(200);
                return $article;
            } else {
                http_response_code(400);
            }
        } 

        
    }
}