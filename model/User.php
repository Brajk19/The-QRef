<?php

    namespace model;


    class User{

        /**
         * @return string
         * Returns first and last name of currently logged in user.
         */
        public static function getFullName(): string {
            $db = Database::getInstance();

            $sessionId = $_COOKIE["sessionID"];

            $query = <<<SQL
                SELECT session.email
                FROM session
                WHERE session.sessionID = :sessionID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":sessionID" => $sessionId]);
            $data = $data->fetchAll();

            $email = $data[0]["email"];
            $query = <<<SQL
                SELECT user.firstName, user.lastName
                FROM user
                WHERE user.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);
            $data = ($data->fetchAll())[0];

            $firstName = $data["firstName"];
            $lastName = $data["lastName"];
            return "$firstName $lastName";
        }
    }

?>