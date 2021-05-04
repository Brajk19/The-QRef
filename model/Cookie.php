<?php

    namespace model;

    class Cookie{

        /**
         * @param string $username
         * @param string $sessionID
         * Adds new session to database.
         */
        public static function addSession(string $username, string $sessionID): void {
            $db = Database::getInstance();

            $query = <<<SQL
                INSERT INTO session
                VALUES (:sessionID, :username)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":sessionID" => $sessionID, ":username" => $username]);
        }

        /**
         * @param string $sessionID
         * Removes session from database (if it exists there).
         */
        public static function deleteSession(string $sessionID):void {
            $db = Database::getInstance();

            $query = <<<SQL
                DELETE FROM session
                WHERE session.sessionID = :sessionID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":sessionID" => $sessionID]);
        }

        /**
         * @param string $sessionID
         * @return bool
         * Returns true if given sessionID exists in database, return false otherwise
         */
        public static function checkSessionID(string $sessionID): bool {
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT COUNT(*) as findSession
                FROM session
                WHERE session.sessionID = :sessionID
            SQL;

            $data = $db->prepare($query);
            $data->execute([":sessionID" => $sessionID]);
            $data = $data->fetchAll();

            if($data[0]["findSession"] === "1"){
                return true;
            }
            return false;
        }

        public static function getSessionID(): string{
            return $_COOKIE["sessionID"];
        }

        public static function setCookie(string $sessionID): void{

            setcookie("sessionID", $sessionID, time() + 86400, "/");
            //jednom dnevno je potrebno ulogirat se (naravno osim ako se ne odjavis)
        }

        public static function deleteCookie(): void{
            setcookie("sessionID", "", time() - 1, "/");
        }

        public static function checkCookie(): bool{
            return isset($_COOKIE["sessionID"]);
        }
    }

?>