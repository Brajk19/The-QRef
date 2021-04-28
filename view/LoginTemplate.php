<?php

    namespace view;

    use router\Router;

    abstract class LoginTemplate extends PageTemplate {
        abstract protected function message();

        public function __construct() {
            parent::__construct();
        }

        protected function generateBody():void {
            start_form($this->router->getRoute("VerifyLogin"), "POST");
            echo create_element("input", true, ["name" => "username", "type" => "text", "placeholder" => "Username"]);
            echo create_element("input", true, ["name" => "password", "type" => "password", "placeholder" => "Password"]);
            echo create_element("input", true, ["type" => "submit", "value" => "Login"]);
            end_form();

            start_form($this->router->getRoute("Register"), "POST");
            echo create_element("input", true, ["type" => "submit", "value" => "Register"]);
            end_form();

            $this->message();
        }


    }

?>