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

        /**
         * @param string $email
         * @return string
         * Returns user's date of birth
         */
        public static function getBirthDate(string $email): string {
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT user.dateOfBirth
                FROM user
                WHERE user.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);
            $data = $data->fetchAll();

            return $data[0]["dateOfBirth"];

        }

        /**
         * Called when user is trying to change password.
         * @param string $password
         * @return bool
         * Returns true if password user entered as current is correct.
         */
        public static function verifyPassword(string $password): bool{
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT password.passwordHash
                FROM password
                WHERE password.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $_SESSION["email"]]);
            $data = $data->fetchAll();

            $correctPassword = $data[0]["passwordHash"];

            if(password_verify($password, $correctPassword)){
                return true;
            }
            return false;
        }

        public static function changePassword(string $newPassword): void{
            $db = Database::getInstance();
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $query = <<<SQL
                UPDATE password
                SET password.passwordHash = :passwordHash
                WHERE password.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $_SESSION["email"], ":passwordHash" => $passwordHash]);
        }
    }

?>