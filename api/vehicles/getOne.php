<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/VehicleService.php';


$vehicle = VehicleService::getInstance()->getOne();
if($vehicle) {
    http_response_code(200);
    echo json_encode($vehicles);
} else {
    http_response_code(400);
}



?>