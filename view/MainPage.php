<?php

    namespace view;


    use router\Router;

    class MainPage extends PageTemplate {
        protected function generateBody() {
            MainPageHeader::printHTML();
            echo create_element("p", true, ["style" => "margin-top:50px"]);
            MainPageBar::printHTML();
        }
    }

?>