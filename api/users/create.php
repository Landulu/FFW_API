<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/UserService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$existingUser = UserService::getInstance()->getOneByEmail($obj['email']);

if($existingUser) {
    http_response_code(409);
} else {    
    $newUser = UserService::getInstance()->create(new User($obj));
    
    if($newUser) {
        http_response_code(201);
        echo json_encode($newUser);
    } else {
        http_response_code(400);
    }
}

?>