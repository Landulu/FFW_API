<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/ProductService.php';
require_once __DIR__ . '/../../services/ArticleService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

//on crée le produit si l'article existe
$article = ArticleService::getInstance()->getOne($obj["articleId"]);
if($article){
    $newProduct = ProductService::getInstance()->create(new Product($obj));
    if($newProduct) {
        http_response_code(201);
        echo json_encode($newProduct);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(404);
}



?>