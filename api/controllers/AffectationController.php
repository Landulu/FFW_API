<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 23/05/19
 * Time: 15:03
 */

include_once 'models/Affectation.php';
include_once 'models/CompleteAffectation.php';
include_once 'services/AffectationService.php';
require_once("Controller.php");

class AffectationController extends Controller{


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): AffectationController {
        if(!isset(self::$controller)) {
            self::$controller = new AffectationController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {

        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $affectations = AffectationService::getInstance()->getAll($offset, $limit);

            if(isset($_GET['completeData'])){

                $methodsArr=[
                    "service"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getSerid"]
                    ];
                $affectations=parent::decorateModel($affectations,$methodsArr);
            }

            return $affectations;
        }

        //create address
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $affectation = AffectationService::getInstance()->create(new Affectation($obj));
            if($affectation) {
                http_response_code(201);
                return $affectation;
            } else {
                http_response_code(400);
            }
        }

        /*
        PUT: 'address/{int}'
        */
        // update One by Id

//        if ( count($urlArray) == 2 && $method == 'PUT') {
//            $json = file_get_contents('php://input');
//            $obj = json_decode($json, true);x
//
//            $affectation = AffectationService::getInstance()->update(new Affectation($obj),$urlArray[1]);
//
//            if($affectation) {
//                http_response_code(201);
//                return $affectation;
//            } else {
//                http_response_code(400);
//            }
//        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $affectation = AffectationService::getInstance()->getOne($urlArray[1]);
            if($affectation) {
                http_response_code(200);
                return $affectation;
            } else {
                http_response_code(400);
            }
        }
    }

    public static function decorateAffectation( $affectations){

        $serviceManager= ServiceService::getInstance();
        $affectations=json_decode(json_encode($affectations),true);

        foreach($affectations as $key=>$affectation){
            $affectation = new CompleteAffectation($affectation);
            $affectation->setService($serviceManager->getOne($affectation->getSerid()));
            $affectations[$key]=$affectation;
        }

        return $affectations;
    }


}