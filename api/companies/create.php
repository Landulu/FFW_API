<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/CompanyService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$newCompany = CompanyService::getInstance()->create(new Company($obj));
if($newCompany) {
    http_response_code(201);
    echo json_encode($newCompany);
} else {
    http_response_code(400);
}

?>