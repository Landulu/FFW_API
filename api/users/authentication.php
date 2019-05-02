<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/UserService.php';

$userEmail = urldecode($_GET['email']);
$userPwd = urldecode($_GET['password']);


$user = UserService::getInstance()->getOneByEmail($userEmail);
if($user) {
    if (isset($userPwd) && isset($user['password'])){
        if( password_verify($userPwd, $user['password'])){
            echo json_encode($user);
        } else {
            http_response_code(403);
        }
    } else {
        http_response_code(400);
    }

} else {
    http_response_code(400);
}



?>