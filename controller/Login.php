<?php

    namespace controller;

    use exception\IncorrectPasswordException;
    use exception\InvalidUsernameException;
    use view\LoginErrorScreen;
    use view\LoginScreen;

    class Login {

        public function __construct() {}

        public function showLogin(): void{
            $ls = new LoginScreen();
            $ls->generateHTML();
        }

        public function verifyLogin(): void{
            try{
                $successfulLogin = \model\Login::verifyLogin($_POST["username"], $_POST["password"]);

                if($successfulLogin === true){
                    //TODO - valja
                    //dodati session ID u kolacice i bazu podataka
                }
                else{
                    //TODO - ne valja
                    //poruka da
                }
            }
            catch(InvalidUsernameException | IncorrectPasswordException $e) {
                $ls = new LoginErrorScreen($e);
                $ls->generateHTML();
            }


        }

        /**
         * @return bool Returns true if someone is already logged in.
         */
        public function isLoggedIn(): bool {
            /* kad se korisnik ulogira, on dobije svoj session ID koji se spremi u kolačiće
             * i traje tjedan dana tako da se ne mora svaki put opet ulogirati
            */

            if(isset($_COOKIE["sessionID"])){
                return true;
            }

            return false;
        }
    }

?>