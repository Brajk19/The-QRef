<?php

    namespace view;

    class EditQuizSuccess extends MainPage {
        protected function generateBody(): void {
            parent::generateBody();

            echo create_element("h1", true, ["contents" => "Quiz successfully edited.",
                "style" => "text-align:center; color:lightgreen"]);
        }
    }

?>