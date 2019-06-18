<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/ArticleService.php';
require_once("Controller.php");


class ArticlesController extends Controller {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): ArticlesController {
        if(!isset(self::$controller)) {
            self::$controller = new ArticlesController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $articles = services\ArticleService::getInstance()->getAll($offset, $limit);
            return $articles;
        }


        //create article
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newArticle = services\ArticleService::getInstance()->create(new Article($obj));
            if($newArticle) {
                http_response_code(201);
                return $newArticle;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $article = services\ArticleService::getInstance()->getOne($urlArray[1]);
            if($article) {
                http_response_code(200);
                return $article;
            } else {
                http_response_code(400);
            }
        } 

        
    }
}