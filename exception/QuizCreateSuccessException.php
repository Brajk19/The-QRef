<?php

    namespace exception;

    class QuizCreateSuccessException extends \Exception {
        public function __construct(){
            parent::__construct("Quiz successfully created.");
        }
    }

?>