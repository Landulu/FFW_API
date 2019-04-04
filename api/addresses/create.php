<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/AddressService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newAddress = AddressService::getInstance()->create(new Address($obj));
if($newAddress) {
    http_response_code(201);
    echo json_encode($newAddress);
} else {
    http_response_code(400);
}

?>