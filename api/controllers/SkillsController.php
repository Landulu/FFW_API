<?php


include_once 'utils/routing/Request.php';
include_once 'utils/routing/Router.php';

include_once 'services/SkillService.php';
include_once 'services/UserService.php';
include_once 'services/AffectationService.php';


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
            if($skills) {
                http_response_code(200);
                return $skills;
            } else {
                http_response_code(400);
            }
        }


        //create skill
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



        /*
         * /skills/[skid]/users
         */
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'users'
            && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $users = UserService::getInstance()->getAllBySkill($urlArray[1], $offset, $limit);
            if($users) {
                http_response_code(200);
                return $users;
            } else {
                http_response_code(400);
            }

        }

        /*
         * /skills/[skid]/availableUsers
         */
        if ( count($urlArray) == 3
            && ctype_digit($urlArray[1])
            && $urlArray[2] == 'availableUsers'
            && $method == 'GET') {

            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
            $start = new Date($_GET['start']);
            $end = new Date($_GET['end']);


            $users = UserService::getInstance()->getAllBySkill($urlArray[1], $offset, $limit);
            if($users) {
                $availableUsers = [];
                foreach ($users as $key => $user) {
                    $affectations = AffectationService::getInstance()->getAllByUserBetweenDates($urlArray[1],$start, $end);
                    if (count($affectations) == 0) {
                        array_push($availableUsers, $user);
                    }
                }
                if (count($availableUsers) > 0) {
                    http_response_code(200);
                    return $availableUsers;
                } else {
                    http_response_code(204);
                    return null;
                }
            } else {
                http_response_code(400);
            }

        }


    }

}