<?php

    namespace controller;

    use view\EditQuiz;

    class QuizList {
        private int $id;

        public function __construct(int $id){
            $this->id = $id;
        }

        /**
         * Lists all quizzes in app.
         */
        public function showAllQuizzes(): void{
            $ql = new \view\QuizList();
            $ql->generateHTML();
        }

        /**
         * Lists all quizzes in app and displays description and comments for selected quiz.
         */
        public function detailedView(): void{
            $ql = new \view\QuizList($this->id);
            $ql->generateHTML();
        }


    }

?>