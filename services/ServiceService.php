<?php
/**
 * Created by PhpStorm.
 * User: landulu
 * Date: 27/05/19
 * Time: 17:08
 */


require_once __DIR__.'/../models/Service.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class ServiceService {

    private static $instance;

    private function __construct(){}

    public static function getInstance(): ServiceService {
        if (!isset(self::$instance)) {
            self::$instance = new ServiceService();
        }
        return self::$instance;
    }


}