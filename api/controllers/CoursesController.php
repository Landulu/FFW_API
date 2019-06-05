<?php
include_once __DIR__.'/../../services/ServiceService.php';
include_once __DIR__.'/../../services/CourseService.php';


class CoursesController {
    private static $controller;

    private function __construct(){}


    public static function getController(): CoursesController {
        if(!isset(self::$controller)) {
            self::$controller = new CoursesController();
        }
        return self::$controller;
    }

    public function proccessQuery($urlArray, $method){


        //get all
        /*
            /courses
        */
        if ( count($urlArray) == 1 && $method == 'GET') {
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

            $courses = CourseService::getInstance()->getAll($offset, $limit);

            if (count($courses) == 0) {
                http_response_code(204);
                return [];
            } else {
                return $courses;

            }

        }


        //create course
        if ( count($urlArray) == 1 && $method == 'POST') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newCourse = CourseService::getInstance()->create(new Service($obj));
            if($newCourse) {
                http_response_code(201);
                return $newCourse;
            } else {
                return $newCourse;
                http_response_code(400);
            }
        }

        // get One by Id
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'GET') {

            $course = CourseService::getInstance()->getOne($urlArray[1]);
            if($course) {
                return $course;

            } else {
                http_response_code(400);
            }
        }


        // update One by Id
        /*
            /services/{uid}
        */
        if ( count($urlArray) == 2 && ctype_digit($urlArray[1]) && $method == 'PUT') {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);

            $newCourse = CourseService::getInstance()->update(new Service($obj),$urlArray[1]);
            if($newCourse) {
                http_response_code(201);
                return $newCourse;
            } else {
                http_response_code(400);
            }
        }

    }
}