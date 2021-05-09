<?php

    namespace exception;

    class NoQuestionsUploadedException extends \Exception {
        public function __construct(){
            parent::__construct("Quiz must contain at least one question.");
        }
    }

?>