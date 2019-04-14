<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/CompanyService.php';


$companies = CompanyService::getInstance()->getAll();
if($companies) {
    http_response_code(200);
    echo json_encode($companies);
} else {
    http_response_code(400);
}



?>