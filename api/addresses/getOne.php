<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/AddressService.php';


$address = AddressService::getInstance()->getOne();
if($address) {
    http_response_code(200);
    echo json_encode($address);
} else {
    http_response_code(400);
}



?>