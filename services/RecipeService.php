<?php
namespace services;
require_once __DIR__.'/../models/Recipe.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class RecipeService extends Service
{

    private static $instance;

    private function __construct() { }

    public static function getInstance(): RecipeService {
        if(!isset(self::$instance)) {
            self::$instance = new RecipeService();
        }
        return self::$instance;
    }

    public function create(\Recipe $recipe){
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
            "INSERT INTO
        recipe (title, content)
        VALUES (?, ?)", [
            $recipe->getTitle(),
            $recipe->getContent()
        ]);
        if($affectedRows > 0) {
            $recipe->setReid($manager->lastInsertId());
            return $recipe;
        }
        return NULL;
    }

    public function getOne($id):?\Recipe {
        $manager = DatabaseManager::getManager();
        $recipe = $manager->getOne(
            "SELECT 
        recipe.re_id as reid,
        recipe.title,
        recipe.content
        FROM
        recipe
        WHERE re_id = ?",
            [$id]
        );
        if ($recipe) {
            $recipeObj = new \Recipe($recipe);
            return $recipeObj;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "SELECT 
        re_id as reid,
        title, 
        content
        FROM recipe
        LIMIT $offset, $limit"
        );
        $recipes = [];

        foreach ($rows as $row) {
            $recipes[] = new \Recipe($row);
        }
        return $recipes;
    }

    public function getAllCookableByLocal($loid) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
            "select recipe.re_id as reid,
        recipe.title,
        recipe.content
        from recipe
        JOIN recipe_requires_ingredient rri ON recipe.re_id = rri.recipe_re_id
        GROUP BY recipe_re_id
        HAVING COUNT(ingredient_in_id) = (
            SELECT COUNT(DISTINCT in_id)
            FROM ingredient
            JOIN recipe_requires_ingredient i on ingredient.in_id = i.ingredient_in_id
            JOIN article a on ingredient.in_id = a.ingredient_in_id
            JOIN product p on a.a_id = p.article_a_id
            JOIN room r on p.room_r_id = r.r_id
            JOIN local l on r.local_lo_id = l.lo_id
            WHERE l.lo_id = ?
            AND recipe_re_id = rri.recipe_re_id
        )
        LIMIT 10",[$loid]
        );
        $recipes = [];

        foreach ($rows as $row) {
            $recipes[] = new \Recipe($row);
        }
        return $recipes;
    }





}