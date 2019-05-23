<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/UserService.php';
include_once 'services/BasketService.php';
include_once 'services/SkillService.php';
include_once 'services/ProductService.php';
include_once 'services/ArticleService.php';



class UsersController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): UsersController {
        if(!isset(self::$controller)) {
            self::$controller = new UsersController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {


        //get all
        /*
            /users
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $users = Userservice::getInstance()->getAll($offset, $limit);
            return $users;
        }


        //create users
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newUser = UserService::getInstance()->create(new User($obj));
            if($newUser) {
                http_response_code(201);
                return $newUser;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $user = UserService::getInstance()->getOne($urlArray[1]);
            if($user) {
                http_response_code(200);
                return $user;
            } else {
                http_response_code(400);
            }
        } 


        // update One by Id
        /*
            /users/{uid}
        */
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newUser = UserService::getInstance()->update(new User($obj));
            if($newUser) {
                http_response_code(201);
                return $newUser;
            } else {
                http_response_code(400);
            }
        } 

        // get One by email
        /*
            users/byemail
        */
        if ( count($urlArray) == 2
        && $urlArray[2] == 'byemail'        
        && $method == 'GET') {

            
            if($_GET['email']) {
                $userEmail = $_GET['email'];

                $user = UserService::getInstance()->getOneByEmail($userEmail);
                if($user) {
                    http_response_code(200);
                    return $user;
                } else {
                    http_response_code(400);
                }
            }else {
                http_response_code(404);
            }
        } 



        // get baskets by userid
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'baskets'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $baskets = BasketService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);
            if($baskets) {
                http_response_code(200);
                return $baskets;
            } else {
                http_response_code(400);
            }

        } 

        // get baskets by userid
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'address'
        && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
            $baskets = BasketService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);
            if($baskets) {
                http_response_code(200);
                return $baskets;
            } else {
                http_response_code(400);
            }

        } 

        // get skills by userid
        /*
            /users/{int}/skills
        */
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'skills'
        && $method == 'GET') {
            
            $skills = SkillService::getInstance()->getAllByUser($urlArray[1]);
            if($skills) {
                http_response_code(200);
                return $skills;
            } else {
                http_response_code(400);
            }

        } 


        //authentication
        /*
            /users/authentication
        */
        if ( count($urlArray) == 2
        && $urlArray[1] == 'authentication'
        && $method == 'GET') {
            return 0;
        }


        // create basket from user
        /*
            /users/{uid}/basket
        */
        if ( count($urlArray) == 3
        && ctype_digit($urlArray[1]) 
        && $urlArray[2] == 'basket'
        && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $basket = json_decode($json, true);

            $role = $_GET('role');
            if ($basket && isset($basket['products']) && isset($basket['u_id']) && isset($role)) {

                $newBasket = new Basket(array(
                    "createTime" => date('Y/m/d H:i:s'),
                    "status" => 'PENDING',
                    "role" => $role,
                    "userId" => $basket['u_id']
                ));
                $createdBasket = Basketservice::getInstance()->create($newBasket);

                if($createdBasket) {
                    foreach ($basket['products'] as $productGroup) {


                        $article = ArticleService::getInstance()->getOne($productGroup['barcode']);

                        if ($article == null) {
                            
                            $url = "https://world.openfoodfacts.org/api/v0/product/" . $productGroup['barcode'] . ".json";

                            $curlArticle = json_decode(CurlManager::getManager()->curlGet($url));
                            

                            if ($curlArticle['status_verbose'] == "product found") {
                                $newArticle = new Article(array(
                                    "aid" => $curlArticle['code'],
                                    "name" => $curlArticle['product']['product_name'] . ' ' . $curlArticle['product']['generic_name'],
                                    "category" => $curlArticle['product']['categories']
                                ));
            
                                $article = ArticleService::getInstance()->create($newArticle);
                            } else {
                                http_response_code(404);
                            }
                            
                        }

                        foreach ($productGroup['peremptions'] as $peremptionProduct) {
                            $quantity = isset($peremptionProduct['quantity'])? $peremptionProduct['quantity'] : 1;
                            for ($i=0; $i < $quantity; $i++) {
                                $newProduct = new Product(array(
                                    "limitDate" => $peremptionProduct['limitDate'],
                                    "state" => isset($peremptionProduct['state'])? $peremptionProduct['state'] : null,
                                    "quantityUnit" => isset($peremptionProduct['quantityUnit'])? $peremptionProduct['quantityUnit'] : null,
                                    "weightQuantity" => isset($peremptionProduct['weightQuantity'])? $peremptionProduct['weightQuantity'] : null,
                                    "articleId" => $article->getAid(),
                                ));

                                $product = ProductService::getInstance()->create($newProduct);

                                if( $product) {
                                    $inserted= BasketService::getInstance()->affectProductToBasket($product->getPrid(), $createdBasket->getBId());
                                    if ($inserted) {
                                        return $basket;
                                    } else {
                                        http_response_code(500);
                                    }
                                } else {
                                    http_response_code(500);
                                }
        
                            }
                        }
                        

                    }
     
                } else {
                    http_response_code(400);
                }


              
            } else {
                http_response_code(400);
            }
        }
        

    }
}