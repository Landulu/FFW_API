<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ArticleService.php';

$articleId = $_GET['a_id'];

$article = ArticleService::getInstance()->getOne($articleId);
if($article) {
    http_response_code(200);
    echo json_encode($article);
} else {
    http_response_code(400);
}



?>