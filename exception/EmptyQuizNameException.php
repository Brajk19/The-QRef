<?php

    namespace exception;

    class EmptyQuizNameException extends \Exception {
        public function __construct(){
            parent::__construct("Quiz name and description must not be empty");
        }
    }

?>