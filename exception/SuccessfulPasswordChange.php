<?php

    namespace exception;


    class SuccessfulPasswordChange extends \Exception {
        public function __construct(){
            parent::__construct("Password changed successfully.");
        }
    }

?>