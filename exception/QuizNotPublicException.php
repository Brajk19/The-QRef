<?php

    namespace exception;

    class QuizNotPublicException extends \Exception {
        public function __construct(string $id) {
            parent::__construct("Quiz with id $id is not public." . "<br>" . "Please register to play it.");
        }
    }

?>