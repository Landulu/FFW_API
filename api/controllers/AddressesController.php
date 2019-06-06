<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 23/05/19
 * Time: 15:03
 */


include_once 'services/AddressService.php';

class AddressesController{


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): AddressesController {
        if(!isset(self::$controller)) {
            self::$controller = new AddressesController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $addresses = AddressService::getInstance()->getAll($offset, $limit);
            return $addresses;
        }


        //create address
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            try {
                $address=new Address($obj);
            }
            catch(Exception $e){
                http_response_code($e->getCode());
                return $e->getMessage();
            }

            $address = $this->gMapGeolocate($address);

            $address = AddressService::getInstance()->create($address);

            if($address) {
                http_response_code(201);
                return $address;
            } else {
                http_response_code(400);
            }
        }

        /*
        PUT: 'address/{int}'
        */
        // update One by Id

        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            try {
                $address=new Address($obj);
            }
            catch(Exception $e){
                http_response_code($e->getCode());
                return $e->getMessage();
            }

            $address = $this->gMapGeolocate($address);

            $address = AddressService::getInstance()->update($address,$urlArray[1]);

            if($address) {
                http_response_code(201);
                return $address;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $address = AddressService::getInstance()->getOne($urlArray[1]);
            if($address) {
                http_response_code(200);
                return $address;
            } else {
                http_response_code(400);
            }
        }
    }
}