<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/ProductService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newProduct = ProductService::getInstance()->create(new Product($obj));
if($newProduct) {
    http_response_code(201);
    echo json_encode($newProduct);
} else {
    http_response_code(400);
}



?>