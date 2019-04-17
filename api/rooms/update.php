<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/RoomService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$updatedRoom = RoomService::getInstance()->update(new Room($obj));
if($updatedRoom) {
    http_response_code(200);
    echo json_encode($updatedRoom);
} else {
    http_response_code(400);
}



?>