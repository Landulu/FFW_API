<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ProductService.php';

$json = file_get_contents('php://input');
$productIds = json_decode($json, true);

if(sizeof($productIds)>0){
    $removedProduct = ProductService::getInstance()->remove($productIds);
    
    if ($removedProduct>0) {
        http_response_code(200);
        echo json_encode($removedProduct);
    } else {
        http_response_code(204);
    }
}
else {
    http_response_code(400);
}




?>