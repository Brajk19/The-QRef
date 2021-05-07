<?php

namespace exception;


class IncorrectPasswordFormatException extends \Exception {
    public function __construct(){
        parent::__construct("Invalid password." . "<br>" .
        "Password must be at least 5 characters long and contain 
        at least one digit, uppercase and lowercase letter." . "<br>" .
        "Allowed characters: 0-9, a-z, A-Z, -, _");
    }
}

?>