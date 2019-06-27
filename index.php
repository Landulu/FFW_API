<?php

ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
include_once 'controllers/AppController.php';
include_once 'utils/curl/CurlManager.php';

$appController = AppController::getController();
echo (json_encode($appController->processQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));




//try
//{
//    $tsp = TspBranchBound::getInstance();
//    $tsp->addLocation(array('id'=>'newquay', 'latitude'=>50.413608, 'longitude'=>-5.083364));
//    $tsp->addLocation(array('id'=>'manchester', 'latitude'=>53.480712, 'longitude'=>-2.234377));
//    $tsp->addLocation(array('id'=>'london', 'latitude'=>51.500152, 'longitude'=>-0.126236));
//    $tsp->addLocation(array('id'=>'birmingham', 'latitude'=>52.483003, 'longitude'=>-1.893561));
//    $ans = $tsp->solve();
//    echo "\nTotal cost: " . ceil($ans['cost']) . "\n\n";
//}
//catch (Exception $e)
//{
//    echo $e;
//    exit;
//}

//var_dump($ans);
