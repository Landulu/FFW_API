<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/UserService.php';

$userId = $_GET['u_id'];

$user = UserService::getInstance()->getOne($userId);
if($user) {
    http_response_code(200);
    echo json_encode($user);
} else {
    http_response_code(400);
}



?>