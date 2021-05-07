<?php

    namespace view;
    use Exception;

    class ChangePasswordError extends ChangePassword{
        private Exception $e;

        public function __construct(Exception $e) {
            parent::__construct();

            $this->e = $e;
        }

        protected function generateBody(): void{
            parent::generateBody();

            echo create_element("p", true, ["style" => "color:red; font-size:30px", "contents" => $this->e->getMessage()]);
        }
    }

?>