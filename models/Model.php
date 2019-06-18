<?php
/**
 * Created by PhpStorm.
 * User: sbailleu
 * Date: 11/06/2019
 * Time: 18:00
 */
require_once ("Model.php");

abstract class Model
{
    public abstract function getMainId();

    protected function controlSetArr($arg,$argName,$controlArgNameArr){

        foreach($controlArgNameArr as $controlArgName){
            if($controlArgName==$argName){
                if(is_array($arg)){
                    $arg=$arg[array_key_first($arg)];
                }
                $this->{'set'.$argName}($arg,true);
                return null;
            }
        }
    }

    public static function convertModelType($type,$object){

        if(!is_object($object)){
            return null;
        }
        $className=get_class($object);

        include_once ($className.".php");

        $typedClassName=strpos($className,ucfirst($type))!==false?$className:ucfirst($type).$className;

        include_once ($typedClassName.".php");

        $object=json_decode(json_encode($object),true);

        $typeObject= new $typedClassName($object);

        return $typeObject;

    }

}