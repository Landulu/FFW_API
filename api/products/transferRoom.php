<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/ProductService.php';
require_once __DIR__ . '/../../services/RoomService.php';

$roomId = $_GET['room_id'];

$json = file_get_contents('php://input'); //read body
$productIds = json_decode($json, true);


if (sizeof($productIds) > 0) {
    $room = RoomService::getInstance()->getOne($roomId);
    if ( $room && $room->getIsUnavailable() == "FREE" && $room->getIsStockroom()) {
        $affectedProducts = ProductService::getInstance()->transferRoomForProducts($productIds, $roomId);

        if ($affectedProducts > 0) {
            echo $affectedProducts;
        } else {
            echo "0";
            http_response_code(204);
        }
    } else {
        http_response_code(406);
    }
} else {
    http_response_code(400);
}




?>