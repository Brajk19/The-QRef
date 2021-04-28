<?php

    namespace controller;

    use router\Router;
    use view\RegistrationErrorScreen;
    use view\RegistrationScreen;

    class Register{
        public function __construct() {}

        public function showRegister():void {
            $rs = new RegistrationScreen();
            $rs->generateHTML();
        }

        public function verifyRegistration():void {
            var_dump($_SESSION["teststst"]);
            $_SESSION["errorMessage"] = [];
            if(!isset($_POST["firstName"]) || empty($_POST["firstName"])) $_SESSION["errorMessage"][] = "Missing first name.";
            if(!isset($_POST["lastName"]) || empty($_POST["lastNmae"])) $_SESSION["errorMessage"][] = "Missing last name.";
            if(!isset($_POST["dateOfBirth"]) || empty($_POST["dateOfBirth"])) $_SESSION["errorMessage"][] = "Missing date of birth.";
            if(!isset($_POST["email"]) || empty($_POST["email"])) $_SESSION["errorMessage"][] = "Missing e-mail.";

            $router = Router::getInstance();
            $nextPage = $router->getRoute("Register");

            header("Location: $nextPage");

            /*
             * TODO
             * provjere zaporke i maila
             */
        }

    }

?>