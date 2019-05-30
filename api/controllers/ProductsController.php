<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'utils/curl/CurlManager.php';

require_once 'services/ProductService.php';
require_once 'services/ArticleService.php';


class ProductsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): ProductsController {
        if(!isset(self::$controller)) {
            self::$controller = new ProductsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {

        /*
        GET: '/'
        */
        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $products = Productservice::getInstance()->getAll($offset, $limit);
            return $products;
        }


        /*
        POST: '/'
        */
        //create products
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);

            $product = new Product($obj);

            if ($product) {
                
                $article = ArticleService::getInstance()->getOne($product->getArticleId());

                if ($article == null) {
                    
                    $url = "https://world.openfoodfacts.org/api/v0/product/" . $product->getArticleId() . ".json";

                    $curlArticle = json_decode(CurlManager::getManager()->curlGet($url), true);

                    


                    if ($curlArticle['status_verbose'] == "product found") {
                        // COOL I GUESS
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

                if($article != null) {   
                    $newProduct = ProductService::getInstance()->create(new Product($obj));
                    if($newProduct) {
                        http_response_code(201);
                        return $newProduct;
                    } else {
                        http_response_code(400);
                    }
                }
                    
            } else {
                http_response_code(400);
            }
        }


        /*
        GET: 'products/{int}'
        */
        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {
            $product = ProductService::getInstance()->getOne($urlArray[1]);
            if($product) {
                http_response_code(200);
                return $product;
            } else {
                http_response_code(400);
            }
        } 


         /*
        PUT: 'products/{int}'
        */
        // update One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {

            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);

            $product = new Product($obj);

            $product = ProductService::getInstance()->update($product);
            if($product) {
                http_response_code(200);
                return $product;
            } else {
                http_response_code(400);
            }
        } 


        /*
        GET: 'products/{int}'
        */
        // get products by room Id
        // if ( count($urlArray) == 3
        // && ctype_digit($urlArray[1]) 
        // && $urlArray[2] == 'products'
        // && $method == 'GET') {

        //     $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
        //     $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            
        //     $products = ProductService::getInstance()->getAllByRoom($urlArray[1], $offset, $limit);
        //     if($products) {
        //         http_response_code(233);
        //         return $products;
        //     } else {
        //         http_response_code(400);
        //     }

        // } 
    }
}