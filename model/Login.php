<?php
    namespace model;

    use exception\IncorrectPasswordException;
    use exception\InvalidUsernameException;


    class Login{

        /**
         * @param string $email E-mail
         * @param string $password Password
         * @return string Returns new session ID if login was successful or NULL if email does not exist / password was wrong.
         * @throws InvalidUsernameException
         * @throws IncorrectPasswordException
         */
        public static function verifyLogin(string $email, string $password): string {
            $db = Database::getInstance();

            $query = <<<SQL
                SELECT password.passwordHash
                FROM password
                WHERE password.email = :email
            SQL;

            $data = $db->prepare($query);
            $data->execute([":email" => $email]);
            $data = $data->fetchAll();

            if(empty($data)){
                throw new InvalidUsernameException();
            }
            else{
                $correctPassword = $data[0]["passwordHash"];

                if(password_verify($password, $correctPassword)){
                    $sessionID = "";
                    for($i = 0; $i < 5; $i++) { //top notch security :)
                        $sessionID .= uniqid(strval(rand()), true);
                    }

                    return $sessionID;
                }
                else{
                    throw new IncorrectPasswordException();
                }
            }
        }
    }

?>