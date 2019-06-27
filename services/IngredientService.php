<?php
namespace services;
require_once __DIR__.'/../models/Ingredient.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class IngredientService extends Service {

    private static $instance;

    private function __construct(){}

    public static function getInstance(): IngredientService {
        if (!isset(self::$instance)) {
            self::$instance = new IngredientService();
        }
        return self::$instance;
    }

    public function create(\Ingredient $ingredient): ?\Ingredient{
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO
        ingredient(name)
        VALUES (?)", [
            $ingredient->getName()
        ]);
        if ($affectedRows > 0) {
            $ingredient->setInid($manager->lastInsertId());
            return $ingredient;
        }
        return NULL;
    }


    public function getAll($offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        in_id as inid,
        name
        from
        ingredient
        LIMIT $offset, $limit"
        );
        $ingredients = [];

        foreach ($rows as $row) {
            $ingredients[] = new \Ingredient($row);
        }

        return $ingredients;
    }

    public function getOne( $inid) {
        $manager = \DatabaseManager::getManager();
        $ingredient = $manager->getOne(
            "SELECT 
        in_id as inid,
        name
        from
        ingredient
        WHERE  in_id= ?",
            [$inid]);
        if($ingredient){
            return new \Ingredient($ingredient);
        }
    }
    //Fin modification

    public function update(\Ingredient $ingredient): ?\Ingredient {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "UPDATE ingredient
        SET  name= ?,
        WHERE aff_id= ? ", [
            $ingredient->getInid(),
            $ingredient->getName()
        ]);
        if ($affectedRows > 0) {
            return $ingredient;
        }
        return NULL;
    }

    public function getAllByRecipe($reid) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        in_id as inid,
        name
        from
        ingredient
        JOIN recipe_requires_ingredient on recipe_requires_ingredient.ingredient_in_id = ingredient.in_id
        JOIN recipe on recipe.re_id = recipe_requires_ingredient.recipe_re_id and recipe.re_id = ?", [$reid]
        );
        $ingredients = [];

        foreach ($rows as $row) {
            $ingredients[] = new \Ingredient($row);
        }

        return $ingredients;
    }

}