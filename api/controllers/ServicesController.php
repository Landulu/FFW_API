<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 27/05/19
 * Time: 17:04
 */
include_once __DIR__ . '/../../services/ServiceService.php';
require_once("Controller.php");

class ServicesController extends Controller {
    private static $controller;

    private function __construct(){}


    public static function getController(): ServicesController {
        if(!isset(self::$controller)) {
            self::$controller = new ServicesController();
        }
        return self::$controller;
    }

    public function proccessQuery($urlArray, $method){


        //get all
        /*
            /services
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $services = ServiceService::getInstance()->getAll($offset, $limit);
            $methodsArr=[
                "vehicle"=>["serviceMethod"=>"getOne"],
                "skill"=>["serviceMethod"=>"getAllByService"],
                "affectation"=>["serviceMethod"=>"getAllByService"],
                "baskets"=>[
                    "serviceMethod"=>"getAllByService",
                    "completeMethods"=>[
                        "user"=>["serviceMethod"=>"getOne"]]
                    ]];

            return parent::decorateModel($services,$methodsArr);

            return $services;
//            return "toto";
        }


        //create services
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newService = ServiceService::getInstance()->create(new Service($obj));
            if($newService) {
                http_response_code(201);
                return $newService;
            } else {
                return $newService;
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $service = ServiceService::getInstance()->getOne($urlArray[1]);
            if($service) {
                return $service;

            } else {
                http_response_code(400);
            }
        }


        // update One by Id
        /*
            /services/{uid}
        */
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newService = ServiceService::getInstance()->update(new Service($obj),$urlArray[1]);
            if($newService) {
                http_response_code(201);
                return $newService;
            } else {
                http_response_code(400);
            }
        }

    }


}