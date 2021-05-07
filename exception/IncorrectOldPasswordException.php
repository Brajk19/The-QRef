<?php

    namespace exception;


    class IncorrectOldPasswordException extends \Exception {
        public function __construct(){
            parent::__construct("Incorrect current password.");
        }
    }

?>