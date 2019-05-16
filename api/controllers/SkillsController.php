<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/SkillService.php';


class SkillsController {


    private static $controller;
    


    private function __construct(){}

    
    public static function getController(): SkillsController {
        if(!isset(self::$controller)) {
            self::$controller = new SkillsController();
        }
        return self::$controller;
    }


    public function proccessQuery($urlArray, $method) {

        //get all
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $skills = SkillService::getInstance()->getAll($offset, $limit);
            return $skills;
        }


        //create article
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input'); 
            $obj = json_decode($json, true);
            
            $newSkill = SkillService::getInstance()->create(new Skill($obj));
            if($newSkill) {
                http_response_code(201);
                return $newSkill;
            } else {
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $skill = SkillService::getInstance()->getOne($urlArray[1]);
            if($skill) {
                http_response_code(200);
                return $skill;
            } else {
                http_response_code(400);
            }
        } 

        
    }

}