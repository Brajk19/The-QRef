<?php

    namespace controller;

    use model\Quizzes;
    use view\QuizFinishUser;

    class Comments {

        /**
         * Adds comment to quiz.
         * All data needed will be in $_POST
         */
        public function addComment(): void{
            Quizzes::addComment($_SESSION["quizID"], $_SESSION["email"], $_POST["commentText"]);

            $qfa = new QuizFinishUser($_SESSION["q"], $_SESSION["ua"], $_SESSION["aa"]);
            $qfa->generateHTML();
        }
    }

?>