<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ProductService.php';


$products = ProductService::getInstance()->getAll();
if($products) {
    http_response_code(200);
    echo json_encode($products);
} else {
    http_response_code(400);
}



?>