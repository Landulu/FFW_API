<?php
include_once __DIR__ . '/../services/FavoriteService.php';
require_once("Controller.php");

class FavoriteController extends Controller {
    private static $controller;

    private function __construct(){}


    public static function getController(): FavoriteController {
        if(!isset(self::$controller)) {
            self::$controller = new FavoriteController();
        }
        return self::$controller;
    }

    public function processQuery($urlArray, $method){


        //get all
        /*
            /favorite
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            if(isset($_GET['user_id']) && ctype_digit($_GET['user_id'])){
                $userId = $_GET['user_id'];
                $favorites = services\FavoriteService::getInstance()->getAllByUser($userId, $offset, $limit);
            } else {
                $favorites = services\FavoriteService::getInstance()->getAll($offset, $limit);
            }
            return $favorites;
        }


        //create favorite
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newFavorite = services\FavoriteService::getInstance()->create(new Favorite($obj));
            if($newFavorite) {
                http_response_code(201);
                return $newFavorite;
            } else {
                return $newFavorite;
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $favorite = services\FavoriteService::getInstance()->getOne($urlArray[1]);
            if($favorite) {
                return $favorite;

            } else {
                http_response_code(400);
            }
        }


        // update One by Id
        /*
            /favorite/{uid}
        */
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newFavorite = services\FavoriteService::getInstance()->update(new Favorite($obj),$urlArray[1]);
            if($newFavorite) {
                http_response_code(201);
                return $newFavorite;
            } else {
                http_response_code(400);
            }
        }


    }


}