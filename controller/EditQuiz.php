<?php

    namespace controller;

    use model\Quizzes;
    use router\Router;
    use view\EditQuizSuccess;

    class EditQuiz {
        private int $id;

        public function __construct(int $id){
            $this->id = $id;
        }

        public function editQuiz(): void{
            try{
                $quiz = Quizzes::getQuiz($this->id);

                $_SESSION["changeID"] = $this->id;
                $eq = new \view\EditQuiz($quiz);
                $eq->generateHTML();

                unset($_SESSION["changeID"]);
            }
            catch (\Exception $e){
                $nextPage = Router::getInstance()->getRoute("MainPage");
                header("Location: $nextPage");
                die();
            }
        }

        public function applyChanges(): void{
            $public = isset($_POST["public"]) ? "1" : "0";
            $comments = isset($_POST["comments"]) ? "1" : "0";

            $qref = "";
            $i = 0;
            while(isset($_POST["question$i"])){
                $qref .= $_POST["question$i"];
                $i++;
            }

            \model\CreateQuiz::updateQuiz(strval($this->id), $_POST["quizName"], $_POST["description"], $public, $comments, $qref);

            $eqs = new EditQuizSuccess();
            $eqs->generateHTML();
        }
    }

?>