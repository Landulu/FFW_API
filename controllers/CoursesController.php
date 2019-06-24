<?php
include_once __DIR__ . '/../services/ServiceService.php';
include_once __DIR__ . '/../services/AffectationService.php';
include_once __DIR__ . '/../services/CourseService.php';
include_once __DIR__ . '/../services/AddressService.php';
include_once __DIR__ . '/../services/BasketService.php';
include_once __DIR__ . '/../utils/pathfinding/TspBranchBound.php';
include_once __DIR__ . '/../models/CompleteService.php';
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
                    return array("basketOrder"=>$arrBasketOrder,"duration"=>$res["cost"]);
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
            /courses/{id}
        */
        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            if(isset($_GET["completeData"])){
                $service=new CompleteService($obj);
            }
            else{
                $service=new Service($obj);
            }
            return var_dump($service);
            $newCourse = services\CourseService::getInstance()->update($service);

            if($newCourse) {
                http_response_code(201);
                if(isset($_GET["completeData"])){
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
                    $newCourse=parent::decorateModel($newCourse,$arrMethods);
                }
                return $newCourse;
            } else {
                http_response_code(400);
            }
        }


        // /courses/{id}/reporting
        if ( count($urlArray) == 3 && ctype_digit($urlArray[1]) && $urlArray[2] == "reporting" && $method == 'GET') {

            $course = CourseService::getInstance()->getOne($urlArray[1]);
            if($course) {

                $affectations = AffectationService::getInstance()->getAllByService($urlArray[1],0, 20 );
                $baskets = BasketService::getInstance()->getAllByService($urlArray[1], 0, 30);  // TODO: WE NEED FULL BASKETS

                $methodsArr=[
                    "company"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getCompanyId",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                    "user"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getUserId",
                        "completeMethods"=>["addre  ss"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                    "external"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getExternalId",
                        "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]]
                ];

                $completeBaskets =  parent::decorateModel($baskets,$methodsArr);



                if ($affectations && $baskets) {

                    $workers = [];

                    for ($i = 0; $i < count($affectations); $i++) {
                        array_push($workers, UserService::getInstance()->getOne($affectations[$i]->uid));
                    }


                    $workerTable = '<table><tr><th>Employé</th></tr>';

                    foreach ($workers as $worker) {
                        $workerRow = '<tr><td>' . $worker->getFirstname() .  ' ' . $worker->getLastname() . '</td></tr>';
                        $workerTable .= $workerRow;
                    }

                    $workerTable .= '</table>';

                    $addressTable = '<table><tr><th>Employé</th></tr>';



//                    $addresses = [];
//
//                    for ($i = 0; $i < count($baskets); $i++) {
//                        array_push($addresses, AddressService::getInstance()->($baskets[$i]->uid));
//                    }

                    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
                    $pdf->SetAuthor('FFW');
                    $pdf->SetTitle('FFW Collect Sheet');

    // set default header data
    //                $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

    // set header and footer fonts
                    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
                    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
                    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
                    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
                    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // add a page
                    $pdf->AddPage();

                    $html = '<h4>Descriptif de route</h4><br><p>'.$course->getName().'</p><p> ('.$course->getServiceTime().')</p>';

                    $pdf->writeHTML($html, true, false, true, false, '');
    // add a page
                    $pdf->AddPage();

                    $html = '<h1>Hey</h1>';
    // output the HTML content
                    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
                    $pdf->lastPage();
    //Close and output PDF document
                    $pdf->Output('example_006.pdf', 'I');

                }
            } else {
                http_response_code(400);
            }
        }

    }
}
