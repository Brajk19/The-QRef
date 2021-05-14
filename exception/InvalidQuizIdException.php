<?php

    namespace exception;

    class InvalidQuizIdException extends \Exception {
        public function __construct(string $id) {
            parent::__construct("Quiz with id $id does not exist.");
        }
    }

?>