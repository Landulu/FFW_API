<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/CompanyService.php';


$company = CompanyService::getInstance()->getOne();
if($company) {
    http_response_code(200);
    echo json_encode($company);
} else {
    http_response_code(400);
}



?>