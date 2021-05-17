<?php

    namespace utility;

    final class OpenTriviaDatabaseAPI {
        private static ?OpenTriviaDatabaseAPI $object = NULL;

        private function __construct(
            private string $url = "https://opentdb.com/api.php?amount=1&type=multiple",
            private string $qrefSkeleton = "<text>{1}:<option1>,<option2>,<option3>,<option4>,<correct>;",
            private array $num = [1, 2, 3, 4]   //for shuffling so the correct answer isn't always on same spot
        ) {}

        private function __clone() {}

        public static function getInstance(): OpenTriviaDatabaseAPI { //singleton
            if(is_null(self::$object)){
                self::$object = new OpenTriviaDatabaseAPI();
            }

            return self::$object;
        }


        /**
         * @return string
         * Returns random question from opentdb API and converts it into .qref format.
         */
        public function getQuestion(): string{
            $json = file_get_contents($this->url);
            $object = json_decode($json, true);

            $qref = $this->qrefSkeleton;
            shuffle($this->num);
            $validQuestion = true; //if retrieved question contains ',' or ';' it will mess up the .qref format
                                    //in that case function is just called again (line 78)

            foreach ($object as $item){
                if(is_array($item)){
                    foreach ($item as $question){  //there's only one question

                        foreach ($question as $key => $value){

                            switch ($key){
                                case "question":
                                    $qref = str_replace("<text>", $value, $qref);

                                    if(str_contains($value, ";")) $validQuestion = false;
                                    break;

                                case "correct_answer":
                                    $index = $this->num[0];
                                    $qref = str_replace(["<option$index>", "<correct>"], $value, $qref);

                                    if(str_contains($value, ";") || str_contains($value, ",")) $validQuestion = false;
                                    break;

                                case "incorrect_answers":
                                    $i = 1;

                                    foreach($value as $incorrectAnswer){
                                        $index = $this->num[$i];
                                        $qref = str_replace("<option$index>", $incorrectAnswer, $qref);
                                        $i++;

                                        if(str_contains($incorrectAnswer, ";") || str_contains($incorrectAnswer, ","))
                                            $validQuestion = false;
                                    }
                                    break;
                            }
                        }
                    }
                }
            }

            if($validQuestion){
                return $qref;
            }
            else {
                return OpenTriviaDatabaseAPI::getInstance()->getQuestion();
            }
        }
    }


?>