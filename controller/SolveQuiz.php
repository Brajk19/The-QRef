<?php

    namespace controller;

    use Exception;
    use exception\QuizNotPublicException;
    use JetBrains\PhpStorm\NoReturn;
    use model\Quizzes;
    use view\QuizFinishAnonymous;
    use view\QuizFinishUser;
    use view\QuizSolveAnonymous;
    use view\QuizSolveUser;

    class SolveQuiz {
        private int $quizID;
        private array $quiz;

        public function __construct(int $id){
            $this->quizID = $id;
        }

        public function loggedIn(): void{
            $x = $this->checkQuizID();
            if($x == true){
                $readyQuiz = $this->formatQuiz();
                $_SESSION["quizID"] = $this->quizID;

                $qsu = new QuizSolveUser(NULL, $readyQuiz);
                $qsu->generateHTML();
            }
            else{
                $q = new QuizSolveUser($x);
                $q->generateHTML();
            }
        }

        public function anonymous(): void{
            $x = $this->checkQuizID();
            $_SESSION["quizID"] = $this->quizID;

            if($x === true){
                $readyQuiz = $this->formatQuiz();

                $qsv = new QuizSolveAnonymous(NULL, $readyQuiz);
                $qsv->generateHTML();
            }
            else{
                $q = new QuizSolveAnonymous($x);
                $q->generateHTML();
            }
        }

        private function checkQuizID(): bool|Exception{
            try{
                $this->quiz = Quizzes::getQuiz($this->quizID);

                //checks if quiz was called from direct link (user that's not logged in)
                if(debug_backtrace()[1]["function"] === "anonymous" && $this->quiz[2] === false){
                    throw new QuizNotPublicException(strval($this->quizID));
                }
            }
            catch (Exception $e){
                return $e;
            }
            return true;
        }

        /**
         * Correct answers are kept in $_SESSION
         * Given answers are in $_POST
         */
        public function verifyAnswers(): void{
            $num = 1;
            $score = 0;

            $arrAns = []; //true for correct answers, false for wrong, NULL for partially correct
            $userAnswers = [];  // format [ [[selected1, selected2,...], [correct1, correct2,...], points], [] ]


            while(isset($_SESSION["question$num"])){
                switch ($_SESSION["question$num"][0]){  //checking the type of question
                    case 1:
                    case 3:
                        if(!isset($_POST["question$num"])){
                            $arrAns[] = false;
                            $userAnswers[] = [[], [$_SESSION["question$num"]], 0];
                        }
                        else if(trim(strtolower($_SESSION["question$num"][1])) === trim(strtolower($_POST["question$num"]))){
                            $arrAns[] = true;
                            $userAnswers[] = [[$_POST["question$num"]], [$_SESSION["question$num"][1]], 1];
                            $score++;
                        }
                        else{
                            $arrAns[] = false;
                            $userAnswers[] = [[$_POST["question$num"]], [$_SESSION["question$num"][1]], 0];
                        }


                        break;

                    case 2:
                        $selected = [];
                        $correct = [];

                        for($i = 1; $i <= 4; $i++){
                            if(isset($_POST["question$num-$i"])){
                                $selected[] = trim($_POST["question$num-$i"]);
                            }

                            if(isset($_SESSION["question$num"][$i])){
                                $correct[] = trim($_SESSION["question$num"][$i]);
                            }
                        }

                        //checks if it's completely correct, partially correct or if everything's wrong
                        if(empty(array_diff($correct, $selected)) && count($correct) === count($selected)){
                            $arrAns[] = true;
                        }
                        else if(!empty(array_intersect($selected, $correct))){
                            $arrAns[] = NULL;
                        }
                        else{
                            $arrAns[] = false;
                        }

                        $points = count(array_intersect($selected, $correct)) - count(array_diff($selected, $correct));
                        $score += $points;
                        $userAnswers[] = [$selected, $correct, $points];
                        break;
                }

                $num++;
            }

            $q = Quizzes::getQuestions($_SESSION["quizID"]);

            $qf = match (isset($_SESSION["email"])){
                true => new QuizFinishUser($q, $userAnswers, $arrAns),
                false => new QuizFinishAnonymous($q, $userAnswers, $arrAns)
            };

            $qf->generateHTML();

            //adding result to database
            if(isset($_SESSION["email"])){
                Quizzes::storeResult($_SESSION["quizID"], $_SESSION["email"], $score);
            }

            //cleaning up
            foreach ($_SESSION as $key => $value){
                if($key !== ["email"]){
                    unset($_SESSION[$key]);
                }
            }
        }


        /**
         * @return array
         * Transforms qref format to format easier to read while generating HTML code in "view".
         */
        private function formatQuiz(): array {
            $q = [];

            $q["name"] = $this->quiz[0];
            $q["description"] = $this->quiz[1];
            $q["comments"] = $this->quiz[3];

            $q["questions"] = [];

            $qrefQuestions = explode(";", $this->quiz[4]);
            array_pop($qrefQuestions); //last iz empty string

            foreach($qrefQuestions as $a){
                $currentQuestion = [];

                preg_match("~.+{~", $a, $arr);
                $currentQuestion["questionText"] = substr($arr[0], 0, -1);

                preg_match("~{[[:digit:]]}~", $a, $arr2);
                $currentQuestion["type"] = intval($arr2[0][1]);

                preg_match("~}:.+~", $a, $arr3);
                $optionsAndAnswers = substr($arr3[0], 2);
                $optionsAndAnswers = explode(",", $optionsAndAnswers);


                switch ($currentQuestion["type"]){
                    case 1:
                    case 2:
                        $currentQuestion["options"] = [];
                        for($i = 0; $i < 4; $i++){
                            $currentQuestion["options"][] = $optionsAndAnswers[$i];
                        }

                        $currentQuestion["answers"] = [];
                        for($i = 4; $i < count($optionsAndAnswers); $i++){
                            $currentQuestion["answers"][] = $optionsAndAnswers[$i];
                        }
                        break;

                    case 3:
                        $currentQuestion["answers"] = [substr($arr3[0], 2)];
                        //because exploding a string won't work when delimiter can't be found in string

                        break;
                }

                $q["questions"][] = $currentQuestion;
            }

            return $q;
        }

    }

?>