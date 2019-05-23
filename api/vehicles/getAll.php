<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/VehicleService.php';

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;


$vehicles = VehicleService::getInstance()->getAll($offset, $limit);
echo json_encode($vehicles);

?>