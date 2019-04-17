<?php

ini_set('display_error', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../services/CompanyService.php';

$json = file_get_contents('php://input'); //read body
$obj = json_decode($json, true);

$updatedCompany = CompanyService::getInstance()->update(new Company($obj));
if($updatedCompany) {
    http_response_code(200);
    echo json_encode($updatedCompany);
} else {
    http_response_code(400);
}

?>