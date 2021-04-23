<?php
    namespace view;

    class LoginScreen {
        public static function generateHTML(): void {
            $router = \router\Router::getInstance();

            create_doctype();

            begin_html();

            begin_head();
            echo create_element("title", true, ["contents" => "Movies"]);
            echo create_element("meta", false, ["charset" => "UTF-8"]);
            end_head();

            begin_body([]);

            start_form($router->getRoute("VerifyLogin"), "POST");
            echo create_element("input", true, ["type" => "text", "placeholder" => "Username"]);
            echo create_element("input", true, ["type" => "password", "placeholder" => "Password"]);
            echo create_element("input", true, ["type" => "submit"]);
            end_form();

            end_body();

            end_html();
        }
    }

?>