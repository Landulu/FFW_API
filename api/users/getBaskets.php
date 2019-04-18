<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/BasketService.php';


$u_id = $_GET['u_id'];

$baskets = BasketService::getInstance()->getAllByUser($u_id);

if($baskets) {
    http_response_code(200);
    echo json_encode($baskets);
} else {
    http_response_code(204);
}



?>