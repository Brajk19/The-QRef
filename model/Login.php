<?php
    namespace model;

    use exception\IncorrectPasswordException;
    use exception\InvalidUsernameException;

    /* NOTE:
     * samo u ovoj klasi provjeravaj kolačić sessionID
     * jer mu je path /Login
     */
    class Login{


        /**
         * @param string $username Username
         * @param string $password Password
         * @return string Returns new session ID if login was successful or NULL if username does not exist / password was wrong.
         */
        public static function verifyLogin(string $username, string $password): string {
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT password.passwordHash
                FROM password
                WHERE password.username = :username
            SQL;

            $data = $db->prepare($query);
            $data->execute([":username" => $username]);
            $data = $data->fetchAll();

            if(empty($data)){
                throw new InvalidUsernameException();
            }
            else{
                $correctPassword = $data[0]["passwordHash"];

                if(password_verify($password, $correctPassword)){
                    $sessionID = "";
                    for($i = 0; $i < 5; $i++) {
                        $sessionID .= uniqid(strval(rand()), true);
                    }
                    // TODO
                    // sessionID dodati u databasu i kolacice
                    echo $sessionID;
                    return $sessionID;
                }
                else{
                    throw new IncorrectPasswordException();
                }
            }
        }


    }

?>