<?php

    namespace exception;

    class SuccessfulRegistrationException extends \Exception{
        public function __construct(){
            parent::__construct("Registration successful.");
        }
    }


?>