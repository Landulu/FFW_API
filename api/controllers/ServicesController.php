<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 27/05/19
 * Time: 17:04
 */

class ServicesController {
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
        if (count($urlArray) == 1 && $method == 'GET') {

        }

    }
}