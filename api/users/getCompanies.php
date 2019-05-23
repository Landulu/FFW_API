<?php


ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/CompanyService.php';


$u_id = $_GET['u_id'];

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

$companies = CompanyService::getInstance()->getAllByUser($u_id, $offset, $limit);

echo json_encode($companies);



