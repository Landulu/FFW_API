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

            $lightObj=Model::convertModelType("Complete",$lightObj);

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
                    $serviceClass="services\\".$serviceClass;

                    if(class_exists($serviceClass)) {

                        $manager = call_user_func(array($serviceClass, "getInstance"));

                        if ($manager  && method_exists($serviceClass,$method["serviceMethod"]) && $requestId) {
                            if (strpos($method["serviceMethod"], "getOne")!==false) {
                                $childObj=$manager->{$method["serviceMethod"]}($requestId);
                                $childObj=isset($method["objectType"])?Model::convertModelType($method["objectType"],$childObj):$childObj;
                                $lightObj->{"set" . ucfirst($methodKey)}($childObj);
                            } else if (strstr($method["serviceMethod"], "getAll")) {

                                $items = [];
                                $offset = 0;
                                $limit = 20;
                                do {
                                    if(isset($method["filters"])){
                                        $newItems = $manager->{$method["serviceMethod"]}($requestId, $offset, $limit,$method["filters"]);
                                    }
                                    else{
                                        $newItems = $manager->{$method["serviceMethod"]}($requestId, $offset, $limit);
                                    }
                                    if (is_array($newItems)) {
                                        $items = array_merge($items, $newItems);
                                    }
                                    $offset += $limit;

                                } while (sizeof($items) % $limit == 0 && sizeof($items) > 0);

                                foreach($items as $itemKey=>$item){
                                    $items[$itemKey]=isset($method["objectType"])?Model::convertModelType($method["objectType"],$item):$item;
                                }
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