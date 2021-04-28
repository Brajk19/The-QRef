<?php

    namespace view;


    class MainPage extends PageTemplate {
        protected function generateBody()
        {
            echo create_element("h1", true, ["contents" => "Main page - in development"]);
        }
    }

?>