<?php

    namespace controller;

    use router\Router;
    use view\RegistrationScreen;

    class Register{
        public function __construct() {}

        public function showRegister():void {
            $rs = new RegistrationScreen();
            $rs->generateHTML();
        }

        public function verifyRegistration():void {
            $_SESSION["errorMessage"] = [];

            if(!isset($_POST["firstName"]) || empty($_POST["firstName"])) $_SESSION["errorMessage"][] = "Missing first name.";
            if(!isset($_POST["lastName"]) || empty($_POST["lastName"])) $_SESSION["errorMessage"][] = "Missing last name.";
            if(!isset($_POST["dateOfBirth"]) || empty($_POST["dateOfBirth"])) $_SESSION["errorMessage"][] = "Missing date of birth.";
            if(!isset($_POST["email"]) || empty($_POST["email"])) $_SESSION["errorMessage"][] = "Missing e-mail.";
            if(!isset($_POST["avatar"]) || empty($_POST["avatar"])) $_SESSION["errorMessage"][] = "Choose an avatar.";

            //provjera zaporke i maila
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                $_SESSION["errorMessage"][] = "Invalid e-mail format.";
            }

            if(\model\Register::duplicateEmail($_POST["email"])){
                $_SESSION["errorMessage"][] = "E-mail already in use.";
            }

            if($_POST["password"] !== $_POST["passwordRepeat"]){
                $_SESSION["errorMessage"][] = "Passwords must match.";
            }

            if($this->regexCheckPassword($_POST["password"]) === false){
                $_SESSION["errorMessage"][] = "Invalid password.";
                $_SESSION["errorMessage"][] = "Password must be at least 5 characters long and contain 
                                        at least one digit, uppercase and lowercase letter.";
                $_SESSION["errorMessage"][] = "Allowed characters: 0-9, a-z, A-Z, -, _";
            }

            if(!empty($_SESSION["errorMessage"])){
                $_SESSION["savedFirstName"] = $_POST["firstName"];
                $_SESSION["savedLastName"] = $_POST["lastName"];
                $_SESSION["savedDateOfBirth"] = $_POST["dateOfBirth"];
                $_SESSION["savedEmail"] = $_POST["email"];

                $this->retryRegistration();
            }
            else{
                //uspjesna registracija
                \model\Register::addNewUser($_POST["firstName"], $_POST["lastName"], $_POST["dateOfBirth"],
                                            $_POST["email"], $_POST["password"], $_POST["avatar"]);

                $router = Router::getInstance();
                $nextPage = $router->getRoute("SuccessfulRegistration");

                header("Location: $nextPage");
                die();
            }
        }

        private function retryRegistration(): void{
            $router = Router::getInstance();
            $nextPage = $router->getRoute("Register");

            header("Location: $nextPage");
            die();
        }

        private function regexCheckPassword(string $password): bool{
            $regex = "^(?=.*[[:upper:]])(?=.*[[:digit:]])(?=.*[[:lower:]]+)[[:alnum:]\-_]{5,}$";

            if(preg_match("~$regex~", $password)) return true;
            return false;
        }

    }

?>