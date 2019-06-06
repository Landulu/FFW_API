<?php

ini_set('display_errors', 1);

header('Content-Type: application/json');



// include_once 'utils/routing/Request.php';
// include_once 'utils/routing/Router.php';

include_once 'api/controllers/AppController.php';
include_once 'utils/curl/CurlManager.php';

include_once 'utils/pathfinding/CourseOptimiser.php';

$appController = AppController::getController();
echo json_encode($appController->proccessQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']));

// $options = Array();



// $curlArticle = json_decode(CurlManager::getManager()->curlGet("https://world.openfoodfacts.org/api/v0/product/3387390406719.json"), true);

// print_r($curlArticle);

// echo($curlArticle['product']['categories']);


// echo $appController->proccessQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);




// $optimiser = CourseOptimiser::getInstance();

// $adj[][] = [[0, 10, 15, 20], 
//                         [10, 0, 35, 25], 
//                         [15, 35, 0, 30], 
//                         [20, 25, 30, 0] ]; 
  
// $optimiser->getShortestPath(adj); 


