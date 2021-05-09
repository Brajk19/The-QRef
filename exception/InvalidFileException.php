<?php

    namespace exception;

    class InvalidFileException extends \Exception {
        public function __construct(){
            parent::__construct("Only .qref files are accepted.");
        }
    }

?>