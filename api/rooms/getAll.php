<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/RoomService.php';


$rooms = RoomService::getInstance()->getAll();
if($rooms) {
    http_response_code(200);
    echo json_encode($rooms);
} else {
    http_response_code(400);
}



?>