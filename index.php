<?php

ini_set('display_errors', 1);

header('Content-Type: application/json');



// include_once 'utils/routing/Request.php';
// include_once 'utils/routing/Router.php';


include_once 'api/controllers/AppController.php';

$appController = AppController::getController();
echo json_encode($appController->proccessQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']));


// echo $appController->proccessQuery($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);


// $router = new Router(new Request);


// $router->get('/', function() {

// });


// $router->get('/profile', function($request) {
//   return <<<HTML
//   <h1>Profile</h1>
// HTML;
// });


// $router->post('/data', function($request) {
//   return json_encode($request->getBody());
// });

// $router->post('/locals', function($request) {
//   return json_encode($request->getBody());
// });



// $router->get('/locals', function($request) {

//   $urlArray = 
//   return 
// });


