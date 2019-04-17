<?php

require_once __DIR__.'UserService.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class AuthenticationService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): AuthenticationService {
        if (!isset(self::$instance)) {
            self::$instance = new AuthenticationService();
        }
        return self::$instance;
    }


    public function isConnected($email, $pwd) {
        
    }

}

?>