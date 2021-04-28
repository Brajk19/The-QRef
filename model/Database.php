<?php
    namespace model;

    use PDO;
    use PDOException;

    class Database
    {
        private static ?PDO $pdo = NULL;

        private function __construct(){}
        private function __clone(){}

        public static function getInstance(): PDO
        {
            if (is_null(self::$pdo)) {
                try {
                    $dsn = "mysql:dbname=qref;" .
                        "host=localhost;charset=utf8";

                    self::$pdo = new PDO($dsn, "root", NULL,
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
                } catch (PDOException $e) {
                    var_dump($e);
                    die();
                }
            }
            return self::$pdo;
        }
    }

