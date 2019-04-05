<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/LocalService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newLocal = LocalService::getInstance()->create(new Local($obj));
if($newLocal) {
    http_response_code(201);
    echo json_encode($newLocal);
} else {
    http_response_code(400);
}



?>