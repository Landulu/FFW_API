<?php

ini_set('display_error', 1);
header('Content-Type: application/json');


require_once __DIR__ . '/../../services/ProductService.php';


$roomId = $_GET['room'];
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;


$products = ProductService::getInstance()->getAllByRoom($roomId, $offset, $limit);

echo json_encode($products);




?>