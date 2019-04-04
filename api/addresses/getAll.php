<?php

ini_set('display_error', 1);
header('Content-Type : application/json');


require_once __DIR__ . '/../../services/AddressService.php';


$addresses = AddressService::getInstance()->getAll();
if($addresses) {
    http_response_code(200);
    echo json_encode($addresses);
} else {
    http_response_code(400);
}



?>