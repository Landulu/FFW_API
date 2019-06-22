<?php
include_once __DIR__ . '/../services/ServiceService.php';
include_once __DIR__ . '/../services/CourseService.php';
include_once __DIR__ . '/../services/AddressService.php';
include_once __DIR__ . '/../services/BasketService.php';
include_once __DIR__ . '/../utils/pathfinding/TspBranchBound.php';
require_once("Controller.php");


class CoursesController extends Controller{
    private static $controller;

    private function __construct(){}


    public static function getController(): CoursesController {
        if(!isset(self::$controller)) {
            self::$controller = new CoursesController();
        }
        return self::$controller;
    }

    public function processQuery($urlArray, $method){


        //get all
        /*
            /courses
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;


            if(isset($_GET['name']) || isset($_GET['routeState']) || isset($_GET['vehicleId']) || isset($_GET['createTime']) || isset($_GET['serviceTime'])){
                $courses = services\CourseService::getInstance()->getAllFiltered($_GET,$offset, $limit);
            }
            else{
                $courses = services\CourseService::getInstance()->getAll($offset, $limit);
            }

            $arrMethods=[
            "vehicle"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getVehicleId"],
            "local"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getLocalId",
                "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAdid"]]],
            "skill"=>["serviceMethod"=>"getAllByService"],
            "affectations"=>["serviceMethod"=>"getAllByService","completeMethods"=>[
                "user"=>["objectType"=>"complete","serviceMethod"=>"getOneByAffectation"]
            ]],
            "baskets"=>[
                "serviceMethod"=>"getAllByService",
                "completeMethods"=>[
                    "company"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getCompanyId",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                    "user"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getUserId",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                    "external"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getExternalId",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                    "local"=>["objectType"=>"complete","serviceMethod"=>"getOneByBasket",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAdid"]]]
                ]
            ]
            ];

            if(isset($_GET["completeData"])){
                $courses=parent::decorateModel($courses,$arrMethods);
            }

            if (count($courses) == 0) {
                http_response_code(204);
                return [];
            } else {
                return $courses;

            }
        }


        if ( count($urlArray) == 2 && $method == 'GET') {

            if(isset($urlArray[1])){
                if($urlArray[1]=="pathFinding"&&$_GET["basketAddressIds"]){

                    $tspManager=TspBranchBound::getInstance();
                    $addressManager=services\AddressService::getInstance();

                    $arrBasketAddressIds=explode(",",$_GET["basketAddressIds"]);

                    foreach($arrBasketAddressIds as $key=>$basketAddressId){

                        $arrBasketAddressIds[$key]=explode("||",$basketAddressId);

                        $addressId=count($arrBasketAddressIds[$key])==2?$arrBasketAddressIds[$key][1]:$arrBasketAddressIds[$key][0];

                        $address=$addressManager->getOne($addressId);

                        $tspManager->addLocation(array('id'=>$basketAddressId[0], 'latitude'=>$address->getLatitude(), 'longitude'=>$address->getLongitude()));
                    }
                    $res=$tspManager->solve();
                    $arrBasketOrder=[];

                    for($i=0; $i<count($res["path"]); $i++) {
                        if(count($arrBasketAddressIds[$res["path"][$i][0]])==2){
                            $arrBasketOrder[]=$arrBasketAddressIds[$res["path"][$i][0]][0];
                        }
                    }
                    return $arrBasketOrder;
                }
            }
        }

        //create course
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newCourse = services\CourseService::getInstance()->create(new Service($obj));
            if($newCourse) {
                http_response_code(201);
                return $newCourse;
            } else {
                return $newCourse;
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $course = services\CourseService::getInstance()->getOne($urlArray[1]);
            if($course) {
                return $course;

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

            $newCourse = services\CourseService::getInstance()->update(new Service($obj),$urlArray[1]);
            if($newCourse) {
                http_response_code(201);
                return $newCourse;
            } else {
                http_response_code(400);
            }
        }

    }
}