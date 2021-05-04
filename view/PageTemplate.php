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
            echo create_element("title", true, ["contents" => "The QRef ?"]);
            echo create_element("meta", false, ["charset" => "UTF-8"]);
            echo create_element("link", false, ["href" => "https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap",
                    "rel" => "stylesheet"]);
            begin_style();
            Css::printHTML();
            end_style();

            end_head();

            begin_body([]);
            $this->generateBody();
            end_body();

            end_html();
        }
    }

?>

