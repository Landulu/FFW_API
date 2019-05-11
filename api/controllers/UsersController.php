<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/UserService.php';
include_once 'services/BasketService.php';


class UsersController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): UsersController {
        if(!isset(self::$controller)) {
            self::$controller = new UsersController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $users = Userservice::getInstance()->getAll($offset, $limit);
            return $users;
        }


        //create users
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newUser = UserService::getInstance()->create(new User($obj));
            if($newUser) {
                http_response_code(201);
                return $newUser;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $user = UserService::getInstance()->getOne($urlArray[1]);
            if($user) {
                http_response_code(200);
                return $user;
            } else {
                http_response_code(400);
            }
        } 

        // get One by email
        if ( count($urlArray) == 2
        && $urlArray[2] == 'byemail'        
        && $method == 'GET') {

            
            if($_GET['email']) {
                $userEmail = $_GET['email'];

                $user = UserService::getInstance()->getOneByEmail($userEmail);
                if($user) {
                    http_response_code(200);
                    return $user;
                } else {
                    http_response_code(400);
                }
            }else {
                http_response_code(404);
            }
        } 



        // get baskets by userid
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'baskets'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $baskets = BasketService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);
            if($baskets) {
                http_response_code(200);
                return $baskets;
            } else {
                http_response_code(400);
            }

        } 

        // get baskets by userid
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'address'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $baskets = AddressService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);
            if($baskets) {
                http_response_code(200);
                return $baskets;
            } else {
                http_response_code(400);
            }

        } 
    }
}