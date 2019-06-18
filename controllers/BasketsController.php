<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/BasketService.php';
include_once 'services/UserService.php';
include_once 'services/CompanyService.php';
include_once 'services/ExternalService.php';

include_once 'CompaniesController.php';
include_once 'ExternalsController.php';
include_once 'AddressesController.php';
include_once 'UsersController.php';


include_once 'models/CompleteBasket.php';

require_once("Controller.php");



class BasketsController extends Controller {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): BasketsController {
        if(!isset(self::$controller)) {
            self::$controller = new BasketsController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;


            if ( isset($_GET['status']) || isset($_GET['role'])) {

                $baskets = services\Basketservice::getInstance()->getAllFiltered($_GET, $offset, $limit);

                if(count($baskets) == 0) {
                    http_response_code(400);
                    return $baskets;
                } else {
                    $methodsArr=[
                        "company"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getCompanyId",
                            "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                        "user"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getUserId",
                            "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                        "external"=>["objectType"=>"complete","serviceMethod"=>"getOne","relationIdMethod"=>"getExternalId",
                            "completeMethods"=>["address"=>["serviceMethod"=>"getOne","relationIdMethod"=>"getAddressId"]]],
                        "products"=>["serviceMethod"=>"getAllByBasket",
                            "completeMethods"=>["article"=>
                                ["serviceMethod"=>"getOne","relationIdMethod"=>"getArticleId","completeMethods"=>[
                                    "ingredient"=>["serviceMethod"=>"getOne","idRelationMethod"=>"getIngredientId"]
                                ]]]]
                        ];
                    return parent::decorateModel($baskets,$methodsArr);
                }


            } else {
                $baskets = services\Basketservice::getInstance()->getAll($offset, $limit);
                if($baskets){
                    http_response_code(200);
                    return $baskets;
                }
                else{
                    http_response_code(400);
                }
            }

        }


        //create basket
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);

            $newBasket = services\Basketservice::getInstance()->create( new Basket($obj));
            if($newBasket) {
                http_response_code(201);
                return $newBasket;
            } else {
                http_response_code(400);
            }
        }

        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newBasket = services\Basketservice::getInstance()->update( new Basket($obj));
            if($newBasket) {
                http_response_code(201);
                return $newBasket;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $basket = services\Basketservice::getInstance()->getOne($urlArray[1]);
            if($basket) {
                http_response_code(200);
                return $basket;
            } else {
                http_response_code(400);
            }
        }

        //get all detailed by status
        /*
         * GET  baskets/status
         */


        
    }

//
//    public static function decorateBasket( $baskets, $optionsArr=["user"=>true,"company"=>true,"external"=>true,"products"=>true]){
//
//        $userManager= services\UserService::getInstance();
//        $companyManager= services\CompanyService::getInstance();
//        $externalManager= services\ExternalService::getInstance();
//        $productManager= services\ProductService::getInstance();
//
//        $baskets=json_decode(json_encode($baskets),true);
//
//        foreach($baskets as $key=>$basket){
//
//            $basket = new CompleteBasket($basket);
//
//            if($basket->getCompanyId()&&isset($optionsArr["company"])){
//                $basket->setCompany($companyManager->getOne($basket->getCompanyId()));
//                $basket->setCompany(CompaniesController::decorateCompany($basket->getCompany(),["address"=>true]));
//                $basket->setAddress($basket->getCompany()->getAddress());
//            }
//            else if($basket->getUserId()&&isset($optionsArr["user"])){
//                $basket->setUser($userManager->getOne($basket->getUserId()));
//                $basket->setUser(UsersController::decorateUser($basket->getUser(), ["address" => true]));
//                $basket->setAddress($basket->getUser()->getAddress());
//            }
//            else if($basket->getExternalId()&&isset($optionsArr["external"])){
//                $basket->setExternal($externalManager->getOne($basket->getExternal()));
//                $basket->setExternal(ExternalsController::decorateExternal($basket->getExternal(), ["address" => true]));
//                $basket->setAddress($basket->getExternal()->getAddress());
//            }
//
//            if(isset($optionsArr["products"])) {
//                $products = [];
//                $offset = 0;
//                $limit = 20;
//
//                do {
//                    $newProducts = $productManager->getAllByBasket($basket->getBId(), $offset, $limit);
//                    if (is_array($newProducts)) {
//                        $products = array_merge($products, $newProducts);
//                    }
//                    $offset += $limit;
//
//                } while (sizeof($products) % $limit == 0 && sizeof($products) > 0);
//                $basket->setProducts($products);
//            }
//            $baskets[$key]=$basket;
//        }
//
//        return $baskets;
//    }
}