<?php

    namespace view;
    use Exception;

    class ChangePasswordError extends ChangePassword{
        private Exception $e;
        private string $color;

        public function __construct(Exception $e, string $color) {
            parent::__construct();

            $this->e = $e;
            $this->color = $color;
        }

        protected function generateBody(): void{
            parent::generateBody();

            echo create_element("p", true, ["style" => "color:$this->color; font-size:30px", "contents" => $this->e->getMessage()]);
        }
    }

?>