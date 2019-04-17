<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/ArticleService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$updatedArticle = ArticleService::getInstance()->update(new Article($obj));
if($updatedArticle) {
    http_response_code(200);
    echo json_encode($updatedArticle);
} else {
    http_response_code(400);
}



?>