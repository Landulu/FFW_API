<?php

require_once __DIR__.'/../models/Article.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class ArticleService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): ArticleService {
        if (!isset(self::$instance)) {
            self::$instance = new ArticleService();
        }
        return self::$instance;
    }


    public function create(Article $article): ?Article {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "INSERT INTO
        article (name, category,is_custom, category_cat_id)
        VALUES (?, ?, 0,0)", [
            $article->getName(),
            $article->getCategory(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

    public function getAll($offset, $limit) {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll(
        "SELECT 
        a_id as aid,
        name,
        is_custom,
        category,
        FROM article
        LIMIT $offset, $limit"
        );
        $articles = [];

        foreach ($rows as $row) {
            $articles[] = new Article($row);
        }

        return $articles;
    }

    public function update(Article $article): ?Article {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec(
        "UPDATE article
        SET 
        name = ?, 
        category =  ?", [
            $article->getName(),
            $article->getCategory(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

    public function getOne(string $aid) {
        $manager = DatabaseManager::getManager();
        $article = $manager->getOne('
        select a_id as aid,
        name,
        is_custom,
        category
        FROM article
        WHERE a_id = ?'
        , [$aid]);
        if ($article) {
            return new Article($article);
        }
    }

}

?>