<?php


    namespace view;

    use router\Router;

    abstract class PageTemplate {
        protected Router $router;

        abstract protected function generateBody();

        public function __construct() {
            $this->router = Router::getInstance();
        }

        public function generateHTML():void {
            create_doctype();

            begin_html();

            begin_head();
            echo create_element("title", true, ["contents" => "Movies"]);
            echo create_element("meta", false, ["charset" => "UTF-8"]);
            end_head();

            begin_body([]);
            $this->generateBody();
            end_body();

            end_html();
        }
    }

?>