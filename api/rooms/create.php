<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/RoomService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newRoom = RoomService::getInstance()->create(new Room($obj));
if($newRoom) {
    http_response_code(201);
    echo json_encode($newRoom);
} else {
    http_response_code(400);
}



?>