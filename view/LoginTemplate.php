<?php

    namespace view;

    use router\Router;

    abstract class LoginTemplate extends PageTemplate {
        abstract protected function message();

        public function __construct() {
            parent::__construct();
        }

        protected function generateBody():void {
            echo create_element("br", false, []);
            echo create_element("br", false, []);
            echo create_element("h1", true, ["contents" => "The QRef ?", "style" => "text-align:center"]);

            start_form($this->router->getRoute("VerifyLogin"), "POST");
            echo create_element("input", true, ["name" => "email", "type" => "text", "placeholder" => "E-mail",
                "size" => "50", "style" => "text-align:center; margin-left:40%"]);
            echo create_element("br", false, []);
            echo create_element("input", true, ["name" => "password", "type" => "password", "placeholder" => "Password",
                "size" => "50", "style" => "text-align:center; margin-left:40%"]);
            echo create_element("br", false, []);
            echo create_element("input", true, ["type" => "submit", "value" => "Login",
                "style" => "text-align:center; margin-left:40%"]);
            end_form();

            start_form($this->router->getRoute("Register"), "POST");
            echo create_element("br", false, []);
            echo create_element("input", true, ["type" => "submit", "value" => "Register",
                "style" => "text-align:center; margin-left:40%"]);
            end_form();


            $this->message();
        }


    }

?>