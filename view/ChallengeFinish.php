<?php

    namespace view;

    class ChallengeFinish extends QuizFinishTemplate {

        public function __construct(array $q, array $a, array $c) {
            parent::__construct();

            //inherited
            $this->questions = $q;
            $this->userAns = $a;
            $this->color = $c;      //true -> green, NULL -> yellow, false -> red
        }

        protected function generateBody() {
            MainPageHeader::printHTML();

            echo create_element("h1", true, ["contents" => "Challenge results", "style" => "text-align:center"]);
            $this->quizStats();
        }
    }


?>