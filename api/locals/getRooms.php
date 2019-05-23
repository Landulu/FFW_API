<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/RoomService.php';


$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
$localId = $_GET['local'];

$rooms = RoomService::getInstance()->getAllByLocal($localId, $offset, $limit);

if($rooms) {
    http_response_code(200);
    echo json_encode($rooms);
} else {
    http_response_code(400);
}



?>