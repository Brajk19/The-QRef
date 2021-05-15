<?php

    namespace view;

    use Exception;

    class QuizSolveUser extends QuizSolveTemplate {
        public function __construct(Exception $e = NULL, array $quiz = NULL) {
            parent::__construct();

            $this->e = $e;
            $this->quiz = $quiz;    //inherited from QuizSolveTemplate
        }

        protected function generateBody():void {
            MainPageHeader::printHTML();
            echo create_element("p", true, ["style" => "margin-top:50px"]);
            $this->pageContent();

        }
    }

?>