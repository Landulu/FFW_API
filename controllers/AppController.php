<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';





class AppController {

    private static $controller;



    private function __construct(){}


    public static function getController(): AppController {
        if(!isset(self::$controller)) {
            self::$controller = new AppController();
        }
        return self::$controller;
    }

    private function formatRoute($route) {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }


    public function processQuery($url, $method) {

        $url = $this->formatRoute($url);


        $urlArray = explode('/', $url);

        $lastElement = $urlArray[count($urlArray) - 1];
        if (strpos($lastElement, '?') !== false) {
            $urlArray[count($urlArray) - 1] = explode('?', $lastElement)[0];
        }
        $sorter = $urlArray[1];

        $className=ucfirst($sorter)."Controller";
        include_once 'controllers/'.$className.'.php';
        if(class_exists($className)){
            $controller=$className::getController();
            return $result=$controller->processQuery(array_slice($urlArray,1),$method);
        }
        else{
            http_response_code(404);
        }



    }
}