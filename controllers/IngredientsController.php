<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 23/05/19
 * Time: 15:03
 */

include_once 'models/Ingredient.php';
include_once 'services/IngredientService.php';
require_once("Controller.php");

class IngredientsController extends Controller{


    private static $controller;



    private function __construct(){}


    public static function getController(): IngredientsController {
        if(!isset(self::$controller)) {
            self::$controller = new IngredientsController();
        }
        return self::$controller;
    }


    public function processQuery($urlArray, $method) {

        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $ingredients = IngredientService::getInstance()->getAll($offset, $limit);

            return $ingredients;
        }

        //create ingredient
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $ingredient = IngredientService::getInstance()->create(new Ingredient($obj));
            if($ingredient) {
                http_response_code(201);
                return $ingredient;
            } else {
                http_response_code(400);
            }
        }

        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $ingredient = IngredientService::getInstance()->update(new Ingredient($obj));
            if($ingredient) {
                http_response_code(201);
                return $ingredient;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $ingredient = IngredientService::getInstance()->getOne($urlArray[1]);
            if($ingredient) {
                http_response_code(200);
                return $ingredient;
            } else {
                http_response_code(400);
            }
        }
    }

    public static function decorateIngredient( $ingredients){

        $serviceManager= ServiceService::getInstance();
        $ingredients=json_decode(json_encode($ingredients),true);

        foreach($ingredients as $key=>$ingredient){
            $ingredient = new Ingredient($ingredient);
            $ingredient->setService($serviceManager->getOne($ingredient->getSerid()));
            $ingredients[$key]=$ingredient;
        }

        return $ingredients;
    }


}