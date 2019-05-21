<?php

class CourseOptimiser {
    private static $instance;

    private function __construct() {
        $this -> pdo = new PDO('mysql:host=' . DB_HOST
                                .';port=' . DB_PORT
                                .';dbname=' . DB_NAME,
                                DB_USER, DB_PWD);
    }

    public static function getManager(): CourseOptimiser {
        if(!isset(self::$instance)) {
            self::$instance = new CourseOptimiser();
        }
        return self::$manager;
    }

}
