<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/AddressService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$updatedAddress = AddressService::getInstance()->update(new Address($obj));
if($updatedAddress) {
    http_response_code(200);
    echo json_encode($updatedAddress);
} else {
    http_response_code(400);
}

?>