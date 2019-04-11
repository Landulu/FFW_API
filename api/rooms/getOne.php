<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/RoomService.php';


$room = RoomService::getInstance()->getOne();
if($room) {
    http_response_code(200);
    echo json_encode($room);
} else {
    http_response_code(400);
}



?>