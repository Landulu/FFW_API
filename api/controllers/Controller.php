<?php
/**
 * Created by PhpStorm.
 * User: sbailleu
 * Date: 11/06/2019
 * Time: 21:21
 */

class  Controller
{
    public static function decorateModel( $lightObjs, $methodsArr){


        if(!$lightObjs){
            return null;
        }
        else if(!is_array($lightObjs)){
            $lightObjs=array($lightObjs);
        }

        foreach($lightObjs as $objKey=>$lightObj){

            $className=get_class($lightObj);
            $completeClassName=strpos($className,"Complete")!==false?$className:"Complete".$className;
            include_once ("models/".$className.".php");
            include_once ("models/".$completeClassName.".php");
            $lightObj=json_decode(json_encode($lightObj),true);

            $lightObj = new $completeClassName($lightObj);

//            var_dump($lightObj);
            foreach($methodsArr as   $methodKey=>$method){

                //relationIdMethod représente un identifiant présent dans un modèle mais qui n'est pas sont identifiant principale;
                if(isset($method["relationIdMethod"])){
                    $requestId=$lightObj->{$method["relationIdMethod"]}();
                }
                else{
                    $requestId=$lightObj->getMainId();
                }

                //serviceMethod est la méthode qui sera appelé par la classe de service instancié ci-dessous
                if(isset($method["serviceMethod"])){

                    $serviceClass=$methodKey;
                    if(substr($methodKey,-3)=="ies"){
                        $serviceClass=substr_replace($methodKey,"y",-3);
                    }
                    else if(substr($methodKey,-1)=="s"&&substr($methodKey,-2)!="ss"){
                        $serviceClass=substr_replace($methodKey,"",-1);
                    }
                    else if(substr($methodKey,-2)=="es"){
                        $serviceClass=substr_replace($methodKey,"",-2);
                    }

                    $serviceClass=ucfirst($serviceClass)."Service";

                    include_once 'services/'.$serviceClass.'.php';

                    if(class_exists($serviceClass)) {

//                        var_dump($method["serviceMethod"]);

                        $manager = call_user_func(array($serviceClass, "getInstance"));

                        if ($manager  && method_exists($serviceClass,$method["serviceMethod"]) && $requestId) {
                            if (strpos($method["serviceMethod"], "getOne")!==false) {
                                $lightObj->{"set" . ucfirst($methodKey)}($manager->{$method["serviceMethod"]}($requestId));
                            } else if (strstr($method["serviceMethod"], "getAll")) {

                                $items = [];
                                $offset = 0;
                                $limit = 20;
                                do {
                                    $newItems = $manager->{$method["serviceMethod"]}($requestId, $offset, $limit);
                                    if (is_array($newItems)) {
                                        $items = array_merge($items, $newItems);
                                    }
                                    $offset += $limit;

                                } while (sizeof($items) % $limit == 0 && sizeof($items) > 0);
                                $lightObj->{"set" . ucfirst($methodKey)}($items);
                            }
                        }
                    }
                }
                if(isset($method["completeMethods"])){
                    $lightObj->{"set" . ucfirst($methodKey)}(self::decorateModel( $lightObj->{"get" . ucfirst($methodKey)}(),$method["completeMethods"]));
                }
            }
            $lightObjs[$objKey]=$lightObj;
        }
        return $lightObjs;
    }

}