<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 15/06/19
 * Time: 21:42
 */




require_once __DIR__.'/../models/Recipe.php';
require_once __DIR__.'/../services/RecipeService.php';
require_once __DIR__.'/../services/IngredientService.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';

require_once("Controller.php");


class RecipesController extends Controller{
    private static $controller;



    private function __construct(){}


    public static function getController(): RecipesController {
        if(!isset(self::$controller)) {
            self::$controller = new RecipesController();
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

            $recipes = RecipeService::getInstance()->getAll($offset, $limit);

            if (count($recipes) > 0) {
                return ($recipes);
            } else {
                http_response_code(204);
            }
        }


        /*
        POST: '/'
        */
        //create recipe
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newRecipe = RecipeService::getInstance()->create(new Recipe($obj));
            if($newRecipe) {
                http_response_code(201);
                return $newRecipe;
            } else {
                http_response_code(400);
            }
        }

        if ( count($urlArray) == 1 && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $recipe = RecipeService::getInstance()->update(new Recipe($obj));

            if($recipe) {
                http_response_code(201);
                return $recipe;
            } else {
                http_response_code(400);
                return $recipe;

            }
        }

        /*
        GET: 'recipes/{int}/ingredients'
        */
        // get products by room Id
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'ingredients'
            && $method == 'GET') {


            $ingredients = IngredientService::getInstance()->getAllByRecipe($urlArray[1]);
            if($ingredients) {
                http_response_code(200);
                return $ingredients;
            } else {
                http_response_code(400);
            }

        }


        http_response_code(404);


    }
}