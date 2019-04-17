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
        $affectedRows = $manager->exec('
        INSERT INTO
        article (name, category)
        VALUES (?, ?)', [
            $article->getName(),
            $article->getCategory(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        article'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }

    public function update(Article $article): ?Article {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        UPDATE article
        SET 
        name = ?, 
        category =  ?', [
            $article->getName(),
            $article->getCategory(),
            ]);
        if ($affectedRows > 0) {
            $article->setAId($manager->lastInsertId());
            return $article;
        }
        return NULL;
    }

}

?>