<?php

    namespace view;


    class RegistrationScreen extends PageTemplate{

        protected function generateBody() {
            start_form($this->router->getRoute("Register"), "POST");
            echo create_element("input", true, ["name" => "firstName", "type" => "text", "placeholder" => "First name"]);
            echo create_element("input", true, ["name" => "lastName", "type" => "text", "placeholder" => "Last name"]);
            echo create_element("input", true, ["name" => "dateOfBirth", "type" => "date"]);
            echo create_element("input", true, ["name" => "email", "type" => "text", "placeholder" => "E-mail"]);
            echo create_element("input", true, ["name" => "password", "type" => "password", "placeholder" => "Password"]);
            echo create_element("input", true, ["name" => "passwordRepeat", "type" => "text", "placeholder" => "Repeat password"]);
            echo create_element("input", true, ["type" => "submit", "value" => "Register"]);
            end_form();
        }
    }

?>