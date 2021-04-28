<?php

    namespace model;


    class Cookie{
        public function __construct() {}

        public function addSession(string $username, string $sessionID): void {
            $db = Database::getInstance();

            $query = <<<SQL
                INSERT INTO session
                VALUES (:sessionID, :username)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":sessionID" => $sessionID, ":username" => $username]);
        }
    }

?>