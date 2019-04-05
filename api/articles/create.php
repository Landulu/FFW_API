<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/ArticleService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newArticle = ArticleService::getInstance()->create(new Article($obj));
if($newArticle) {
    http_response_code(201);
    echo json_encode($newArticle);
} else {
    http_response_code(400);
}



?>