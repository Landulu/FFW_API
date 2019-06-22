<?php

require_once __DIR__.'/conf.php';

class DatabaseManager {
    private $pdo;
    private static $manager;

    private function __construct() {
        $this -> pdo = new PDO('mysql:host=' . DB_HOST
                                .';port=' . DB_PORT
                                .';dbname=' . DB_NAME
                                .';charset='.DB_CHARSET,
                                DB_USER, DB_PWD);
    }

    public static function getManager(): DatabaseManager {
        if(!isset(self::$manager)) {
            self::$manager = new DatabaseManager();
        }
        return self::$manager;
    }


    // 7.1+
    private function internalExec(string $sql, array $params = []): ?PDOStatement {
        $stmt = $this->pdo->prepare($sql);
        if($stmt !== false) {
            if($stmt->execute($params)) {
                return $stmt;
            }
            print_r($stmt->errorInfo());
        }
        return NULL;
    }

    public function exec(string $sql, array $params = []): int {
        $stmt = $this->internalExec($sql, $params);
        if($stmt) {
            return $stmt->rowCount();
        }
        return 0;
    }

    public function getAll(string $sql, array $params = []): array {
        $stmt = $this->internalExec($sql, $params);
        if($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getOne(string $sql, array $params = []): ?array {
        $stmt = $this->internalExec($sql, $params);
        if($stmt) {
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($res){
                return $res; 
            }
        }
        return NULL;
    }

    public function lastInsertId(): ?int {
        return $this->pdo->lastInsertId();
    }
}

?>