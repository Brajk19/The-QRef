<?php

    namespace controller;

    use exception\InvalidQuizIdException;
    use model\Quizzes;
    use view\ChallengeChooseDifficulty;
    use view\ChallengeFinish;
    use view\QuizFinishAnonymous;
    use view\QuizFinishUser;
    use view\QuizSolveUser;

    class Challenge {
        public function chooseDifficulty(): void{
            $csd = new ChallengeChooseDifficulty();
            $csd->generateHTML();
        }

        /**
         * Verifies each answers and displays it along wiht number of points.
         */
        public function verifyChallenge(): void{
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
                            $userAnswers[] = [[], [$_SESSION["question$num"][1]], 0];
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


            $cf = new ChallengeFinish($_SESSION["challenge"], $userAnswers, $arrAns);
            $cf->generateHTML();

            //cleaning up
            foreach ($_SESSION as $key => $value){
                if($key !== "email"){
                    unset($_SESSION[$key]);
                }
            }
        }

        public function easyChallenge(): void{
            $quiz = $this->getRandomQuestions(5);
            $_SESSION["challenge"] = $this->extractQuestionText($quiz);

            $c = new QuizSolveUser(NULL, $quiz);
            $c->generateHTML();
        }

        public function mediumChallenge(): void{
            $quiz = $this->getRandomQuestions(10);
            $_SESSION["challenge"] = $this->extractQuestionText($quiz);

            $c = new QuizSolveUser(NULL, $quiz);
            $c->generateHTML();
        }

        public function hardChallenge(): void{
            $quiz = $this->getRandomQuestions(15);
            $_SESSION["challenge"] = $this->extractQuestionText($quiz);

            $c = new QuizSolveUser(NULL, $quiz);
            $c->generateHTML();
        }

        private function getRandomQuestions(int $n): array{
            $arr = Quizzes::getRandomQuestions($n);

            $difficulty = match($n){
                5 => "Easy difficulty",
                10 => "Medium difficulty",
                15 => "Hard difficulty"
            };
            return $this->formatQuiz($arr, $difficulty);
        }

        /**
         * @param array $qrefQuestions
         * @param string $difficulty
         * @return array
         * Parses the .qref format of quiz and returns it as an array.
         */
        private function formatQuiz(array $qrefQuestions, string $difficulty): array {
            $q = [];

            $q["name"] = "Challenge";
            $q["description"] = $difficulty;
            $q["comments"] = false;

            $q["questions"] = [];

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

        private function extractQuestionText(array $quiz): array{
            $text = [];
            foreach ($quiz["questions"] as $q){
                $text[] = $q["questionText"];
            }

            return $text;
        }
    }

?>