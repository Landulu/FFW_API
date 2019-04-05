<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/LocalService.php';


$local = LocalService::getInstance()->getOne();
if($local) {
    http_response_code(200);
    echo json_encode($local);
} else {
    http_response_code(400);
}



?>