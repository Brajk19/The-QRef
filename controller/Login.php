<?php

    namespace controller;

    use exception\IncorrectPasswordException;
    use exception\InvalidUsernameException;
    use model\Cookie;
    use router\Router;
    use view\LoginErrorScreen;
    use view\LoginScreen;

    class Login {
        private Router $router;
        public function __construct() {
            $this->router = Router::getInstance();
        }

        public function showLogin(): void{
            $ls = new LoginScreen();
            $ls->generateHTML();
        }

        public function verifyLogin(): void{
            try{
                $sessionID = \model\Login::verifyLogin($_POST["username"], $_POST["password"]);

                setcookie("sessionID", $sessionID, time() + 86400);
                //jednom dnevno je potrebno ulogirat se (naravno osim ako se ne odjavis)

                $c = new Cookie();
                $c->addSession($_POST["username"], $sessionID);

                $nextPage = $this->router->getRoute("MainPage");
                header("Location: $nextPage");
                die();
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