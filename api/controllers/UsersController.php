<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/UserService.php';
include_once 'services/AddressService.php';
include_once 'services/BasketService.php';
include_once 'services/SkillService.php';
include_once 'services/ProductService.php';
include_once 'services/ArticleService.php';
include_once 'models/CompleteUser.php';
include_once 'models/CompleteSkill.php';

include_once 'AffectationController.php';



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

            $params = [];

            foreach($_GET as $key=>$value){
                if($key!="offset"&&$key!="limit"){
                    $params[$key]=$value;
                }
            }

            $completeUsers = [];

            if (count($params)) {
                $users = Userservice::getInstance()->getAllFiltered($offset, $limit, $params);
                foreach ($users as $user) {
                    if (isset($params['rights'])) {
                        if ($this->isRightSet($user->getRights(), $params['rights'])) {
                            array_push($completeUsers, $this->decorateCompleteUser($user));
                        }

                    } else {
                        array_push($completeUsers, $this->decorateCompleteUser($user));
                    }
                }
            } else {
                $users = Userservice::getInstance()->getAll($offset, $limit);
                foreach ($users as $user) {
                    array_push($completeUsers, $this->decorateCompleteUser($user));
                }
            }
            if(sizeof($completeUsers)>0){
                http_response_code(200);
                return $completeUsers;
            }
            else{
                http_response_code(400);
            }

            return null;
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
                return $newUser;
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $completeUser = UserService::getInstance()->getOne($urlArray[1]);
            if($completeUser) {
                return $this->decorateCompleteUser($completeUser);

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
        && isset($urlArray[2]) && $urlArray[2] == 'byemail'
        && $method == 'GET') {

            
            if($_GET['email']) {
                $userEmail = $_GET['email'];

                $completeUser = UserService::getInstance()->getOneByEmail($userEmail);
                if($completeUser) {
                    http_response_code(200);
                    return $completeUser;
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

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $skills = SkillService::getInstance()->getAllByUser($urlArray[1],$offset,$limit);


            if($skills) {
                http_response_code(200);
                return $skills;
            } else {
                http_response_code(400);
            }

        }

        // add skills by userid
        /*
            /users/{int}/skills
        */
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'skills'
            && $method == 'POST') {

            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $result = SkillService::getInstance()->affectSkillToUser($urlArray[1],$obj['skid'],$obj['status']);

            if($result) {
                return $result;
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }

        // update skills by userid
        /*
            /users/{int}/skills
        */
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'skills'
            && $method == 'PUT') {

            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $result = SkillService::getInstance()->updateSkillByUser($urlArray[1],$obj['skid'],$obj['status']);

            if($result) {
                return $result;
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }

                /*
        GET: 'users/{int}/companies'
        */
        // get companies by userId
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'companies'
            && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $companies = CompanyService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);
            if($companies) {
                http_response_code(200);
                return $companies;
            } else {
                http_response_code(400);
            }

        }

        /*
        GET: 'users/{int}/affectations'
        */
        // get companies by userId
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'affectations'
            && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $affectations = AffectationService::getInstance()->getAllByUser($urlArray[1], $offset, $limit);

            if(isset($_GET['completeData'])){
                $affectations=AffectationController::decorateAffectation($affectations);
            }

            if($affectations) {
                http_response_code(200);
                return $affectations;
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
            $userEmail = urldecode($_GET['email']);
            $userPwd = urldecode($_GET['password']);

            $completeUser = UserService::getInstance()->getOneByEmail($userEmail);
            if($completeUser) {
                if (isset($userPwd) && isset($completeUser['password'])){
                    if( password_verify($userPwd, $completeUser['password'])){
                        return $completeUser;
                    } else {
                        return $completeUser;

                        http_response_code(403);
                    }
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(400);
            }
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

            $role = $_GET['role'];
            if ($basket && isset($basket['products']) && isset($role)) {

                $newBasket = new Basket(array(
                    "createTime" => date('Y/m/d H:i:s'),
                    "status" => 'PENDING',
                    "role" => $role,
                    "userId" => $urlArray[1]
                ));
                $createdBasket = Basketservice::getInstance()->create($newBasket);

                if($createdBasket) {
                    foreach ($basket['products'] as $productGroup) {


                        $article = ArticleService::getInstance()->getOne($productGroup['barcode']);

                        if ($article == null) {
                            
                            $url = "https://world.openfoodfacts.org/api/v0/product/" . $productGroup['barcode'] . ".json";

                            $curlArticle = json_decode(CurlManager::getManager()->curlGet($url), true);
                            

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
                                    "limitDate" => isset($peremptionProduct['limitDate']) ? $peremptionProduct['limitDate'] : null ,
                                    "state" => isset($peremptionProduct['state'])? $peremptionProduct['state'] : null,
                                    "quantityUnit" => isset($peremptionProduct['quantityUnit'])? $peremptionProduct['quantityUnit'] : null,
                                    "weightQuantity" => isset($peremptionProduct['weightQuantity'])? $peremptionProduct['weightQuantity'] : null,
                                    "articleId" => $article->getAid(),
                                ));

                                $product = ProductService::getInstance()->create($newProduct);

                                if( $product) {
                                    $inserted = BasketService::getInstance()->affectProductToBasket($product->getPrid(), $createdBasket->getBId());
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

    public static function decorateCompleteUser($completeUser,$optionsArr=["skill"=>true,"address"=>true,"company"=>true]) {
        $offset = 0;
        $limit = 20;
        $skills = [];
        $newSkills = [];

        if(isset($optionsArr["skill"])){
            do {
                $newSkills = SkillService::getInstance()->getAllByUser($completeUser->getUid(), $offset, $limit);
                $skills = array_merge($skills, $newSkills);
                $offset += 20;
            } while (count($newSkills) == 20 );
            if ($skills) {
                $completeUser->setSkills($skills);
            }
        }

        if(isset($optionsArr["address"])){
            $address = AddressService::getInstance()->getOneByUserId($completeUser->getUid());
            if($address) {
                $completeUser->setAddress($address);
            }
        }


        if(isset($optionsArr["company"])) {

            $offset = 0;
            $companies = [];
            $newCompanies = [];
            do {
                $newCompanies = CompanyService::getInstance()->getAllByUser($completeUser->getUid(), $offset, $limit);

                if ($newCompanies) {
                    $companies = array_merge($companies, $newCompanies);
                    $offset += 20;
                }

            } while ($newCompanies && count($newCompanies) == 20);
            if ($companies) {
                $completeUser->setCompanies($companies);
            }
        }

        http_response_code(200);
        return $completeUser;
    }

    function isRightSet($byteRight, $pos)
    {
        $new_num = $byteRight >> ($pos - 1);

        // if it results to '1' then bit is set,
        // else it results to '0' bit is unset
        return ($new_num & 1);
    }

}