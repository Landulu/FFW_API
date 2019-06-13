<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';


include_once 'api/controllers/RoomsController.php';
include_once 'api/controllers/LocalsController.php';
include_once 'api/controllers/ArticlesController.php';
include_once 'api/controllers/BasketsController.php';
include_once 'api/controllers/UsersController.php';
include_once 'api/controllers/SkillsController.php';
include_once 'api/controllers/ExternalsController.php';
include_once 'api/controllers/AddressesController.php';
include_once 'api/controllers/CompaniesController.php';
include_once 'api/controllers/ServicesController.php';
include_once 'api/controllers/CoursesController.php';
include_once 'api/controllers/ProductsController.php';
include_once 'api/controllers/VehiclesController.php';




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
        $lastElement = $urlArray[count($urlArray) - 1];
        if (strpos($lastElement, '?') !== false) {
            $urlArray[count($urlArray) - 1] = explode('?', $lastElement)[0];
        }
        $sorter = $urlArray[1];

        switch ($sorter) {
            case 'courses':
                $coursesController = CoursesController::getController();
                $result = $coursesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'vehicles':
                $vehiclesController = VehiclesController::getController();
                $result = $vehiclesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'addresses':
                $addressesController = AddressesController::getController();
                $result = $addressesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'affectations':
                $addressesController = AffectationController::getController();
                $result = $addressesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'articles':
                $articlesController = ArticlesController::getController();
                $result = $articlesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'baskets':
                $basketsController = BasketsController::getController();
                $result = $basketsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'companies':
                $companiesController = CompaniesController::getController();
                $result = $companiesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'externals':
                $externalsController = ExternalsController::getController();
                $result = $externalsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'locals':
                $localsController = LocalsController::getController();
                $result = $localsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'products':
                $productsController = ProductsController::getController();
                $result = $productsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
                break;
            case 'rooms':
                $roomsController = RoomsController::getController();
                $result = $roomsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'scanners':
                # code...
                break;
            case 'services':
                $servicesController = ServicesController::getController();
                $result = $servicesController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'users':
                $usersController = UsersController::getController();
                $result = $usersController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'skills':
                $skillsController = SkillsController::getController();
                $result = $skillsController->proccessQuery(array_slice($urlArray, 1), $method);
                return $result;
            case 'vehicles':
                # code...
                break;
            default:
                http_response_code(404);
                break;
        }



    }
}