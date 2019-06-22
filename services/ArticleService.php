<?php
namespace services;
require_once __DIR__.'/../models/Article.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';
require_once "Service.php";


class ArticleService extends Service {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): ArticleService {
        if (!isset(self::$instance)) {
            self::$instance = new ArticleService();
        }
        return self::$instance;
    }


    public function create(\Article $article): ?\Article {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        article (name, ingredient_in_id)
        VALUES (?, ?, 0,0)", [
            $article->getName(),
            $article->getIngredientId(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = \DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        a_id as aid,
        name,
        ingredient_in_id as ingredientId
        FROM article
        LIMIT $offset, $limit"
        );
        $articles = [];

        foreach ($rows as $row) {
            $articles[] = new \Article($row);
        }

        return $articles;
    }

    public function update(\Article $article): ?\Article {
        $manager = \DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE article
        SET 
        name = ?, 
        ingredient_in_id =  ?", [
            $article->getName(),
            $article->getIngredientId(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

    public function getOne(string $aid) {
        $manager = \DatabaseManager::getManager();
        $article = $manager->getOne('
        select a_id as aid,
        name,
        ingredient_in_id as ingredientId
        FROM article
        WHERE a_id = ?'
        , [$aid]);
        if ($article) {
            return new \Article($article);
        }
    }

}

?>