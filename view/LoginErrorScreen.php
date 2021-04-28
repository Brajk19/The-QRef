<?php

    namespace view;
    use Exception;

    class LoginErrorScreen extends LoginTemplate {
        private Exception $e;

        public function __construct(Exception $e) {
            parent::__construct();

            $this->e = $e;
        }

        protected function message():void {
            echo create_element("p", true, ["contents" => $this->e->getMessage()]);
        }
    }

?>