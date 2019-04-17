<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ProductService.php';


$productId = $_GET['pr_id'];

$product = ProductService::getInstance()->getOne($productId);
if($product) {
    http_response_code(200);
    echo json_encode($product);
} else {
    http_response_code(400);
}



?>