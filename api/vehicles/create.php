<?php

ini_set('display_error', 1);
header('Content-Type : application/json');

require_once __DIR__ . '/../../services/VehicleService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newVehicle = VehicleService::getInstance()->create(new Vehicle($obj));
if($newVehicle) {
    http_response_code(201);
    echo json_encode($newVehicle);
} else {
    http_response_code(400);
}



?>