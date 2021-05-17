<?php

    namespace model;


    class Register {
        /**
         * @param string $firstName
         * @param string $lastName
         * @param string $dateOfBirth
         * @param string $email
         * @param string $password
         * @param string $avatar
         * Stores new user in database.
         */
        public static function addNewUser(string $firstName, string $lastName, string $dateOfBirth,
                                          string $email, string $password, string $avatar):void {

            $db = Database::getInstance();

            $query = <<<SQL
                INSERT INTO user
                VALUES (:firstName, :lastName, :dateOfBirth, :email)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":firstName" => $firstName, ":lastName" => $lastName,
                ":dateOfBirth" => $dateOfBirth, ":email" => $email]);

            $query = <<<SQL
                INSERT INTO avatar
                VALUES (:email, :avatar)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email, ":avatar" => $avatar]);

            $query = <<<SQL
                INSERT INTO password
                VALUES (:email, :hash)
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email, ":hash" => password_hash($password, PASSWORD_DEFAULT)]);

        }

        /**
         * @param string $email
         * @return bool Returns true if email already exists in database
         */
        public static function duplicateEmail(string $email): bool {
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT COUNT(*) AS emailCount
                FROM user
                WHERE user.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);
            $data = $data->fetchAll();

            if($data[0]["emailCount"] === "0"){
                return false;
            }

            return true;
        }
    }

?>