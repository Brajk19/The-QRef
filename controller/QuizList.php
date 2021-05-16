<?php

    namespace controller;

    use view\EditQuiz;

    class QuizList {
        private int $id;

        public function __construct(int $id){
            $this->id = $id;
        }

        public function showAllQuizzes(): void{
            $ql = new \view\QuizList();
            $ql->generateHTML();
        }

        public function detailedView(): void{
            $ql = new \view\QuizList($this->id);
            $ql->generateHTML();
        }


    }

?>