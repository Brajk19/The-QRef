<?php

    namespace controller;

    class Login {

        public function __construct() {}

        public function showLogin(): void{
            \view\LoginScreen::generateHTML();
        }

        public function verifyLogin(): void{
            // TODO
        }
    }

?>