<?php

    namespace exception;


    class InvalidUsernameException extends \Exception{
        public function __construct() {
            parent::__construct("No account with given username, amigo.");
        }
    }

?>