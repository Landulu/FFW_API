<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/UserService.php';


$users = UserService::getInstance()->getAll();
if($users) {
    http_response_code(200);
    echo json_encode($users);
} else {
    http_response_code(400);
}



?>