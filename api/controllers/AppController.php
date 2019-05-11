<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';


include_once 'api/controllers/RoomsController.php';
include_once 'api/controllers/LocalsController.php';



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


    public function proccessQuery($url, $method) {

        $url = $this->formatRoute($url);

        $urlArray = explode('/', $url);
        $sorter = $urlArray[1];

        switch ($sorter) {
            case 'addresses':
                
            case 'articles':
                $articlesController = ArticlesController::getController();
                $result = $articlesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'baskets':
                $basketsController = BasketsController::getController();
                $result = $basketsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'companies':
                # code...
            case 'locals':
                $localsController = LocalsController::getController();
                $result = $localsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'products':
                # code...
            case 'rooms':
                $roomsController = RoomsController::getController();
                $result = $roomsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'scanners':
                # code...
            case 'services':
                # code...
            case 'users':
                $usersController = UsersController::getController();
                $result = $usersController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'vehicles':
                # code...
            default:
                http_response_code(404);
                break;
        }



    }
}