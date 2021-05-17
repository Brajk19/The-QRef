<?php

    namespace controller;


    use exception\EmptyQuizNameException;
    use exception\InvalidFileException;
    use exception\InvalidQrefFileException;
    use exception\NoQuestionsUploadedException;
    use exception\QuizCreateSuccessException;
    use utility\OpenTriviaDatabaseAPI;

    class CreateQuiz {
        public function showCreateQuizPage(): void{
            $cq = new \view\CreateQuiz();
            $cq->generateHTML();
        }


        /**
         * Checks if every field is set and whether or not questions are in valid format.
         */
        public function verifyQuiz(): void{
            $public = isset($_POST["public"]) ? "1" : "0";
            $comments = isset($_POST["enableComments"]) ? "1" : "0";

            //first we check if user wanted to submit quiz or add random question to textarea
            if($_POST["action"] !== "Submit"){
                $_SESSION["quizName"] = $_POST["quizName"];
                $_SESSION["description"] = $_POST["quizDescription"];
                $_SESSION["qref"] = $_POST["qrefText"] . OpenTriviaDatabaseAPI::getInstance()->getQuestion() . "\n";

                $cq = new \view\CreateQuiz();
                $cq->generateHTML();
                die();
            }

            try{
                if(empty($_POST["quizName"]) || empty($_POST["quizDescription"])){
                    throw new EmptyQuizNameException();
                }
                if(empty($_FILES["qrefFile"]["name"]) && empty($_POST["qrefText"])){
                    throw new NoQuestionsUploadedException();
                }

                if(!empty($_FILES["qrefFile"]["name"])){
                    if(preg_match("~^.+\.qref$~", $_FILES["qrefFile"]["name"]) === 0){
                        throw new InvalidFileException();
                    }
                    else{
                        $qref = file_get_contents($_FILES["qrefFile"]["tmp_name"]);

                        if(!$this->verifyQref(file_get_contents($qref))){
                            throw new InvalidQrefFileException();
                        }
                        else{
                            $this->successfulEntry($qref, $public, $comments);
                            die();
                        }
                    }
                }

                if(empty($_FILES["qrefFile"]["name"])){ //checking textArea
                    if(!$this->verifyQref($_POST["qrefText"])){
                        throw new InvalidQrefFileException();
                    }
                    else{
                        $this->successfulEntry($_POST["qrefText"], $public, $comments);
                        die();
                    }
                }
            }
            catch(\Exception $e){
                $_SESSION["quizName"] = $_POST["quizName"];
                $_SESSION["description"] = $_POST["quizDescription"];
                $_SESSION["qref"] = $_POST["qrefText"];

                $cq = new \view\CreateQuiz($e);
                $cq->generateHTML();
                die();
            }
        }

        private function verifyQref(string $questions): bool{
            $qref = explode(";", $questions);
            array_pop($qref);   //last one is empty string

            if(empty($qref)) return false;

            $regex1 = "^.+\{1\}:[^,]+,[^,]+,[^,]+,[^,]+,[^,]+;$"; //for question type 1

            $regex21 = "^.+\{2\}:[^,]+,[^,]+,[^,]+,[^,]+,[^,]+;$";         //type 2 with 1 correct answer
            $regex22 = "^.+\{2\}:[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+;$";
            $regex23 = "^.+\{2\}:[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+;$";
            $regex24 = "^.+\{2\}:[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+,[^,]+;$";

            $regex3 = "^.+\{3\}:.+;$"; //for question type 3
            $regexArr = [$regex1, $regex21, $regex22, $regex23, $regex24, $regex3];

            foreach($qref as $question){
                $question = trim($question);
                $question = "$question;";

                foreach ($regexArr as $regex){
                    if(preg_match("~$regex~", $question) === 1){
                        continue 2;
                    }
                }
                return false;
            }

            return true;
        }

        /**
         * @param string $qref
         * @param string $public
         * @param string $comments
         * Stores quiz to database and displays message to user.
         */
        private function successfulEntry(string $qref, string $public, string $comments): void{
            \model\CreateQuiz::storeQuiz($_POST["quizName"], $_POST["quizDescription"], $public, $comments, $qref);

            $cq = new \view\CreateQuiz(new QuizCreateSuccessException());
            $cq->generateHTML();
        }
    }

?>