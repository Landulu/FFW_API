<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/AddressService.php';

$addressId = $_GET['ad_id'];

$address = AddressService::getInstance()->getOne($addressId);
if($address) {
    http_response_code(200);
    echo json_encode($address);
} else {
    http_response_code(400);
}



?>