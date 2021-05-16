<?php

    namespace view;

    use Exception;
    use router\Router;

    abstract class QuizSolveTemplate extends PageTemplate {

        /**
         * $quiz should have all info about quiz correctly parsed
         *
         * $quiz = ["name" => quizName,
         *          "description" => quizDescription,
         *
         *          //depends on type, shown is for type 1
         *          "questions" => [["type" => 1/2/3, "questionText" => blabla,
         *                           "options" => [opt1, opt2, opt3, opt4],
         *                           "answers" = [ans1]],
         *                          ["questionText] => ... ,
         *                          [], [], [], ... ]
         *          "comments" => true/false
         *         ]
         */
        protected ?array $quiz;
        protected ?Exception $e;

        abstract protected function generateBody();

        protected function errorMsg(): void{
            echo create_element("p", true, ["class" => "quizCreateError", "contents" => $this->e->getMessage()]);
        }

        protected function pageContent(): void {
            if (!is_null($this->e)) {
                $this->errorMsg();
            } else {
                $this->quizForm();
            }
        }



        /**
         * @param array $q Array from $this->quiz["questions"]
         * @param int $i Number of question
         * @return string
         * Returns HTML table row with all info about given question.
         */
        private function singleQuestionHtmlRow(array $q, int $i): string{
            $cell1 = create_table_cell(["style" => "border:2px solid black", "contents" => $q["questionText"]]);
            $cell2 = create_element("td", false, ["style" => "border:2px solid black"]);

            switch ($q["type"]){
                case 1:
                    for($j = 0; $j < 4; $j++){
                        add_to_element($cell2, create_element("input", true, ["type" => "radio", "name" => "question$i",
                                                            "value" => $q["options"][$j]]));
                        add_to_element($cell2, create_element("label", true, ["contents" => trim($q["options"][$j])]));
                        add_to_element($cell2, create_element("br", true, []));
                    }
                    $_SESSION["question$i"] = [1, $q["answers"][0]];
                    break;

                case 2:
                    for($j = 0; $j < 4; $j++){
                        $jj = $j + 1;
                        add_to_element($cell2, create_element("input", true, ["type" => "checkbox", "name" => "question$i-$jj",
                                                            "value" => $q["options"][$j]]));
                        add_to_element($cell2, create_element("label", true, ["contents" => trim($q["options"][$j])]));
                        add_to_element($cell2, create_element("br", true, []));
                    }

                    $_SESSION["question$i"] = [2];
                    foreach ($q["answers"] as $ans){
                        $_SESSION["question$i"][] = $ans;
                    }
                    break;

                case 3:
                    add_to_element($cell2, create_element("input", true, ["type" => "text", "name" => "question$i",
                                                            "placeholder" => "Enter your answer here."]));
                    $_SESSION["question$i"] = [3, $q["answers"][0]];
                    break;
            }


            close_element($cell2);

            return create_table_row(["style" => "text-align:left", "contents" => [$cell1 ,$cell2]]);
        }


        /**
         * Outputs HTML code of all questions.
         */
        protected function quizForm(): void{
            echo create_element("h1", true, ["contents" => $this->quiz["name"], "style" => "text-align:center"]);
            echo create_element("br", false, []);

            echo create_element("h2", true, ["contents" => $this->quiz["description"], "style" => "text-align:center"]);
            echo create_element("br", false, []);


            switch (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[4]["class"]){
                case "controller\SolveQuiz":
                    start_form(Router::getInstance()->getRoute("VerifyAnswers"), "POST");
                    break;
                case "controller\Challenge":
                    start_form(Router::getInstance()->getRoute("VerifyChallenge"), "POST");
                    break;
            }

            start_form(Router::getInstance()->getRoute("VerifyAnswers"), "POST");

            create_table(["class" => "quizTable"]);

            for($i = 0; $i < count($this->quiz["questions"]); $i++){
                echo$this->singleQuestionHtmlRow($this->quiz["questions"][$i], $i + 1);
            }

            end_table();

            echo create_element("input", true, ["type" => "submit", "value" => "Submit", "style" => "margin:auto; display:block"]);

            end_form();
        }
    }

?>