<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/AddressService.php';

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;



$addresses = AddressService::getInstance()->getAll($offset, $value);
if($addresses) {
    http_response_code(200);
    echo json_encode($addresses);
} else {
    http_response_code(400);
}



?>