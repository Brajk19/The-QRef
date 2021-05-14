<?php

    namespace view;

    use Exception;

    class QuizSolveAnonymous extends QuizSolveTemplate {
        private ?Exception $e;

        public function __construct(Exception $e = NULL, array $quiz = NULL) {
            parent::__construct();

            $this->e = $e;
            $this->quiz = $quiz;    //inherited from QuizSolveTemplate
        }

        private function pageContent(): void{
            if(!is_null($this->e)){
                $this->errorMsg();
            }
            else{
                $this->quizForm();
            }
        }

        private function errorMsg(): void{
            echo create_element("p", true, ["class" => "quizCreateError", "contents" => $this->e->getMessage()]);
        }

        protected function generateBody():void {
            MainPageHeaderEmpty::printHTML();
            echo create_element("p", true, ["style" => "margin-top:50px"]);
            $this->pageContent();
        }
    }

?>