<?php

    namespace exception;


    class InvalidQrefFileException extends \Exception {
        public function __construct(){
            parent::__construct("Given questions are not in the valid .qref format.");
        }
    }

?>