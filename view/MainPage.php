<?php

    namespace view;


    use router\Router;

    class MainPage extends PageTemplate {
        protected function generateBody()
        {
            echo create_element("h1", true, ["contents" => "Main page - in development"]);

            start_form(Router::getInstance()->getRoute("Logout"), "POST");
            echo create_element("input", true, ["type" => "submit", "value" => "Logout"]);
            end_form();
        }
    }

?>