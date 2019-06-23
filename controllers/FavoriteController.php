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
            $newFavorite = new Favorite($obj);
            $oldFavorite = services\FavoriteService::getInstance()->getOneByUidAndSid($newFavorite);
            if($oldFavorite != null){                //si le favori existe déjà on l'update juste
                $favorite = services\FavoriteService::getInstance()->update($newFavorite, $oldFavorite['f_id']);
            } else {                                 //sinon on le crée
                $favorite = services\FavoriteService::getInstance()->create($newFavorite);
            }
            if($favorite) {
                http_response_code(201);
                return $favorite;
            } else {
                http_response_code(400);
                return $favorite;
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