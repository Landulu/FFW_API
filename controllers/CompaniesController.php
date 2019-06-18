<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/CompanyService.php';
require_once("Controller.php");


class CompaniesController extends Controller  {

    private static $controller;

    private function __construct(){}


    public static function getController(): CompaniesController {
        if(!isset(self::$controller)) {
            self::$controller = new CompaniesController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {


        /*
        GET: '/'
        */
        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $params = [];

            foreach($_GET as $key=>$value){
                if($key!="offset"&&$key!="limit"){
                    $params[$key]=$value;
                }
            }
            if (count($params)) {
                $companies = services\CompanyService::getInstance()->getAllFiltered($offset, $limit, $params);


            } else {
                $companies = services\CompanyService::getInstance()->getAll($offset, $limit);
            }



            $methodsArr=["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]
            ];
            return parent::decorateModel($companies,$methodsArr);
        }


        /*
        POST: '/'
        */
        //create company
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $company = services\CompanyService::getInstance()->create(new Company($obj));
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

            $company = services\CompanyService::getInstance()->getOne($urlArray[1]);

            if(isset($_GET["completeData"])){
                $methodsArr=[
                    "address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]
                ];
                $company=parent::decorateModel($company,$methodsArr);
            }
            if($company) {
                http_response_code(200);
                return $company;
            } else {
                http_response_code(400);
            }
        }

        /*
        PUT: 'companies/{int}'
        */
        // update One by Id

        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {

            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $company = new Company($obj);

            $company = services\CompanyService::getInstance()->update($company,$company->getCoId());
            if($company) {
                http_response_code(200);
                return $company;
            } else {
                http_response_code(400);
            }
        }

    }

//    public static function decorateCompany($companies,$optionsArr=["address"=>true]){
//
//
//        $addressManager= services\AddressService::getInstance();
//
//        $companies=json_decode(json_encode($companies),true);
//
//        foreach($companies as $key=>$company){
//            $company = new CompleteCompany($company);
//            if(isset($optionsArr["address"])){
//                $company->setAddress($addressManager->getOne($company->getAdid()));
//            }
//            $companies[$key]=$company;
//        }
//
//        return $companies;
//    }
}