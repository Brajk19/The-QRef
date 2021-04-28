<?php

    namespace controller;

    use view\RegistrationScreen;

    class Register{
        public function __construct() {}

        public function showRegister():void {
            $rs = new RegistrationScreen();
            $rs->generateHTML();
        }

        public function verifyRegistration():bool {

            return true;
        }

    }

?>