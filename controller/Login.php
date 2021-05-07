<?php

    namespace controller;

    use exception\IncorrectPasswordException;
    use exception\InvalidUsernameException;
    use exception\SuccessfulRegistrationException;
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

        public function successfulRegistration(): void{
            $ls = new LoginErrorScreen(new SuccessfulRegistrationException());
            $ls->generateHTML();
        }

        public function verifyLogin(): void{
            try{
                $sessionID = \model\Login::verifyLogin($_POST["email"], $_POST["password"]);

                Cookie::setCookie($sessionID);
                Cookie::addSession($_POST["email"], $sessionID);

                endSession();
                startSession();
                $_SESSION["email"] = $_POST["email"];

                $nextPage = $this->router->getRoute("MainPage");
                header("Location: $nextPage");
                die();
            }
            catch(InvalidUsernameException | IncorrectPasswordException $e) {
                $ls = new LoginErrorScreen($e);
                $ls->generateHTML();
            }
        }

        public function logoutUser(): void{
            Cookie::deleteSession($_COOKIE["sessionID"]);
            Cookie::deleteCookie();

            endSession();
            startSession();

            $ls = new LoginScreen();
            $ls->generateHTML();
        }

    }

?>