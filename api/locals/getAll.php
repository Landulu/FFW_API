<?php

ini_set('display_error', 1);
header('Content-Type : application/json');


require_once __DIR__ . '/../../services/LocalService.php';


$locals = LocalService::getInstance()->getAll();
if($locals) {
    http_response_code(200);
    echo json_encode($locals);
} else {
    http_response_code(400);
}



?>