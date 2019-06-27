<?php

ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');
include_once 'controllers/AppController.php';
include_once 'utils/curl/CurlManager.php';

$appController = AppController::getController();
echo (json_encode($appController->processQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));
