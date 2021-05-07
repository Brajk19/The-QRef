<?php

    namespace exception;

    use Throwable;

    class DifferentPasswordException extends \Exception {
        public function __construct(){
            parent::__construct("Passwords are not the same.");
        }
    }

?>