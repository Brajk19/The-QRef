<?php

    namespace view;

    use router\Router;

    class ChallengeChooseDifficulty extends MainPage {
        protected function generateBody():void {
            parent::generateBody();

            echo create_element("br", false, []);
            echo create_element("h1", true, ["contents" => "Choose difficulty", "style" => "text-align:center"]);

            echo create_element("a", true, ["href" => Router::getInstance()->getRoute("EasyChallenge"),
                "contents" => "EASY", "class" => "initial easy"]);

            echo create_element("a", true, ["href" => Router::getInstance()->getRoute("MediumChallenge"),
                "contents" => "MEDIUM", "class" => "initial medium"]);

            echo create_element("a", true, ["href" => Router::getInstance()->getRoute("HardChallenge"),
                "contents" => "HARD", "class" => "initial hard"]);

        }
    }

?>