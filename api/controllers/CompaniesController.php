<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/CompanyService.php';


class CompaniesController {

    private static $controller;

    private function __construct(){}


    public static function getController(): CompaniesController {
        if(!isset(self::$controller)) {
            self::$controller = new CompaniesController();
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

            $company = CompanyService::getInstance()->getAll($offset, $limit);
            return $company;
        }


        /*
        POST: '/'
        */
        //create room
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $company = CompanyService::getInstance()->create(new Company($obj));
            if($company) {
                http_response_code(201);
                return $company;
            } else {
                http_response_code(400);
            }
        }


        /*
        GET: 'rooms/{int}'
        */
        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $company = CompanyService::getInstance()->getOne($urlArray[1]);
            if($company) {
                http_response_code(200);
                return $company;
            } else {
                http_response_code(400);
            }
        }

    }
}