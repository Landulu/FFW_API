<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/BasketService.php';
include_once 'services/UserService.php';
include_once 'services/CompanyService.php';
include_once 'services/ExternalService.php';


include_once 'models/DetailedBasket.php';


class BasketsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): BasketsController {
        if(!isset(self::$controller)) {
            self::$controller = new BasketsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $baskets = Basketservice::getInstance()->getAll($offset, $limit);
            return $baskets;
        }


        //create basket
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newBasket = Basketservice::getInstance()->create(new Basket($obj));
            if($newBasket) {
                http_response_code(201);
                return $newBasket;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $basket = Basketservice::getInstance()->getOne($urlArray[1]);
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
        if ( count($urlArray) == 2 && $method == 'GET' && $urlArray[1] == "status") {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            $status = $_GET['status'];

            if ($offset && $limit && $status) {
                // TODO:$

                $baskets = Basketservice::getInstance()->getAllByStatus($status, $offset, $limit);
                foreach ($baskets as $basket) {
                    if($basket->getCompanyId()) {
                        // $company =
                    } else if ($basket->getExternalId()) {
                        $external = ExternalService::getInstance()->getOne($basket->getExternalId());
                        if ($external->getAddressId()) {
                            $address = AddressService::getInstance()->getOne($external->getAddressId());
                            if ($address) {
                                $basketElement = new DetailedBasket([
                                    "createTime" => $basket->getCreateTime(),
                                    "status" => $basket->getStatus(),
                                    "role" => $basket->getRole(),
                                    "externalId" => $basket->getExternalId(),
                                    "entityName" => $external->getName() != null ? $external->getName() :"Nom inféfini",
                                    "tel" => $external->getTel() != null ? $external->getTel() : null,
                                    "addressId" => $address->getAdId(),
                                    "addressZipCode" => $address->getCityCode(),
                                    "addressName" => $address->getStreetAddress(). ' ' . $address->getCityName()
                                ]);
                            }
                        }

                    } else if ($basket->getUserId()) {
                        $user = UserService::getInstance()->getOne($basket->getUserId());
                        if ($user->getAddressId()) {
                            $address = AddressService::getInstance()->getOne($user->getAddressId());
                            if ($address) {
                                $basketElement = new DetailedBasket([
                                    "createTime" => $basket->getCreateTime(),
                                    "status" => $basket->getStatus(),
                                    "role" => $basket->getRole(),
                                    "userId" => $basket->getUserId(),
                                    "entityName" => $user->getLastname() . ' ' . $user->getFirstName(),
                                    "tel" => $user->getTel() != null ? $user->getTel() : null,
                                    "addressId" => $address->getAdId(),
                                    "addressZipCode" => $address->getCityCode(),
                                    "addressName" => $address->getStreetAddress(). ' ' . $address->getCityName()
                                ]);
                            }
                        }
                    }
                }

            } else {
                http_response_code(400);
            }

        }

        
    }
}