<?php

    namespace view;

    class QuizFinishAnonymous extends QuizFinishTemplate {

        public function __construct(array $q, array $a, array $c) {
            parent::__construct();

            //inherited
            $this->questions = $q;
            $this->userAns = $a;
            $this->color = $c;      //true -> green, NULL -> yellow, false -> red
        }

        protected function generateBody():void {
            MainPageHeaderEmpty::printHTML();
            $this->quizStats();
        }
    }

?>