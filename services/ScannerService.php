<?php

require_once __DIR__.'/../models/Scanner.php';
require_once __DIR__.'/../utils/database/DatabaseManager.php';


class ScannerService {
    private static $instance;

    private function __construct(){}

    public static function getInstance(): ScannerService {
        if (!isset(self::$instance)) {
            self::$instance = new ScannerService();
        }
        return self::$instance;
    }


    public function create(Scanner $scanner): ?Scanner {
        $manager = DatabaseManager::getManager();
        $affectedRows = $manager->exec('
        INSERT INTO
        scanner (version, build_date, emit_date, state)
        VALUES (?, ?, ?, ?)', [
            $scanner->getVersion(),
            $scanner->getBuildDate(),
            $scanner->getEmitDate(),
            $scanner->getState()
            ]);
        if ($affectedRows > 0) {
            $scanner->setScId($manager->lastInsertId());
            return $scanner;
        }
        return NULL;
    }

    public function getAll() {
        $manager = DatabaseManager::getManager();
        $rows = $manager->getAll('
        SELECT * from
        scanner'
        );
        if (sizeof($rows)  > 0) {
            return $rows;
        }
    }

}

?>