<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ArticleService.php';


$articles = ArticleService::getInstance()->getAll();
if($articles) {
    http_response_code(200);
    echo json_encode($articles);
} else {
    http_response_code(400);
}



?>