<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/UserService.php';

$userEmail = $_GET['email'].urldecode;
$userPwd = $_GET['password'].urldecode;


$user = UserService::getInstance()->getOneByEmail($userEmail);
if($user) {
    if (isset($userPwd) && isset($user->password)){
        if( password_verify($_POST["pwd"], $resultat['password'])){
            echo 1;
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