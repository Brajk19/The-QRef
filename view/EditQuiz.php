<?php

    namespace view;

    use router\Router;

    class EditQuiz extends MainPage {
        private array $quiz;

        public function __construct(array $q) {
            parent::__construct();

            $this->quiz = $q;
        }

        private function qrefRows(): void{
            $question = explode(";", $this->quiz[4]);
            array_pop($question);

            for($i = 0; $i < count($question); $i++){
                $cell1 = create_table_cell(["contents" => strval($i + 1). ". question", "style" => "padding:10px"]);

                $quizDescription = create_element("textarea", true, ["name" => "question$i",
                    "cols" => "100", "rows" => "3", "contents" => $question[$i] . ";"]);
                $cell2 = create_table_cell(["contents" => $quizDescription, "style" => "padding:10px"]);

                echo create_table_row(["contents" => [$cell1, $cell2]]);
            }
        }

        protected function generateBody() {
            parent::generateBody();
            echo create_element("br", false, []);

            start_form(Router::getInstance()->getRoute("ApplyChanges", $_SESSION["changeID"]), "POST", ["id" => "editQuiz",
                "style" => "font-size:20px"]);

            $public = match($this->quiz[2]){
                true => create_element("input", true, ["type" => "checkbox", "form" => "editQuiz",
                    "name" => "public", "checked" => ""]),
                false => create_element("input", true, ["type" => "checkbox", "form" => "editQuiz",
                    "name" => "public"])
            };
            $label1 = create_element("label", true, ["contents" => "public"]);

            $comments = match($this->quiz[3]){
                true => create_element("input", true, ["type" => "checkbox", "form" => "editQuiz",
                    "name" => "comments", "checked" => ""]),
                false => create_element("input", true, ["type" => "checkbox", "form" => "editQuiz",
                    "name" => "comments"])
            };
            $label2 = create_element("label", true, ["contents" => "enable comments"]);

            $div1 = create_element("div", false, ["style" => "margin-left: 40%"]);
            add_to_element($div1, $public);
            add_to_element($div1, $label1);
            add_to_element($div1, create_element("br", false, []));
            add_to_element($div1, $comments);
            add_to_element($div1, $label2);
            close_element($div1);

            echo $div1;
            echo create_element("br", false, []);

            create_table(["class" => "quizTable"]);

            $cell11 = create_table_cell(["contents" => "Quiz name", "style" => "padding:10px"]);
            $quizName = create_element("input", true, ["type" => "text", "name" => "quizName", "size" => "50",
                "value" => $this->quiz[0]]);
            $cell12 = create_table_cell(["contents" => $quizName, "style" => "padding:10px; text-align:left"]);

            $cell21 = create_table_cell(["contents" => "Quiz description", "style" => "padding:10px; border-bottom:2px solid black"]);
            $quizDescription = create_element("textarea", true, ["name" => "description",
                "cols" => "100", "rows" => "5", "contents" => $this->quiz[1]]);
            $cell22 = create_table_cell(["contents" => $quizDescription, "style" => "padding:10px; border-bottom:2px solid black"]);

            echo create_table_row(["contents" => [$cell11, $cell12]]);
            echo create_table_row(["contents" => [$cell21, $cell22]]);

            $this->qrefRows();

            end_table();

            echo create_element("input", true, ["type" => "submit", "value" => "Apply changes", "style" => "margin-left:45%"]);
            end_form();
        }
    }

?>