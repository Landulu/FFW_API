<?php
include_once __DIR__ . '/../services/CommentsService.php';
require_once("Controller.php");

class CommentsController extends Controller {
    private static $controller;

    private function __construct(){}


    public static function getController(): ServicesController {
        if(!isset(self::$controller)) {
            self::$controller = new ServicesController();
        }
        return self::$controller;
    }

    public function processQuery($urlArray, $method){


        //get all
        /*
            /comments
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            if(isset($_GET['user_id']) && ctype_digit($_GET['user_id'])){
                $userId = $_GET['user_id'];
                $comments = services\CommentsService::getInstance()->getAllByUser($userId, $offset, $limit);
            } else if (isset($_GET['service_id']) && ctype_digit($_GET['service_id'])){
                $serviceId = $_GET['service_id'];
                $comments = services\CommentsService::getInstance()->getAllByService($serviceId, $offset, $limit);
            } else {
                $comments = services\CommentsService::getInstance()->getAll($offset, $limit);
            }
            return $comments;
        }


        //create comments
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newComments = services\CommentsService::getInstance()->create(new Comments($obj));
            if($newComments) {
                http_response_code(201);
                return $newComments;
            } else {
                return $newComments;
                http_response_code(400);
            }
        }

        // // get One by Id
        // if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

        //     $comments = services\CommentsService::getInstance()->getOne($urlArray[1]);
        //     if($comments) {
        //         return $comments;

        //     } else {
        //         http_response_code(400);
        //     }
        // }


        // update One by Id
        /*
            /comments/{uid}
        */
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newComments = services\CommentsService::getInstance()->update(new Comments($obj),$urlArray[1]);
            if($newComments) {
                http_response_code(201);
                return $newComments;
            } else {
                http_response_code(400);
            }
        }


    }


}