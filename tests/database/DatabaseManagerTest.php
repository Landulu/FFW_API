<?php


ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once __DIR__ . '/../../utils/database/DatabaseManager.php';
require_once __DIR__ . '/../../services/VehicleService.php';
require_once __DIR__ . '/../../services/ProductService.php';


$db = DatabaseManager::getManager();

// $affectedRows = $db->exec('
// INSERT INTO
// Movie (title, duration, release_date, description)
// VALUES (?,?,?,?)', [
//   'Avenger EndGame',
//   156,
//   '2019-04-24',
//   '-'
// ]);

// echo $affectedRows;

// $res = services\VehicleService::getInstance()->getAll();

// $res = services\ProductService::getInstance()->getAllByRoom(1);
// print_r($res);

// $res = 

// echo $res;

// $c = $db->getOne('SELECT * FROM vehicle WHERE v_id = ?', [2]);
// print_r($c);


?>
