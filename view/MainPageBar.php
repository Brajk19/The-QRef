<?php

    namespace view;


    use router\Router;

    class MainPageBar {
        public static function printHTML(): void {
            $createImg = create_element("img", true, ["src" => "../resources/create.png", "class" => "bar"]);
            $createIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("CreateQuiz"),
                "contents" => $createImg]);

            $listImg = create_element("img", true, ["src" => "../resources/list.png", "class" => "bar"]);
            $listIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("QuizList"),
                "contents" => $listImg]);

            $statsImg = create_element("img", true, ["src" => "../resources/stats.png", "class" => "bar"]);
            $statsIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("Stats"),
                "contents" => $statsImg]);

            $challengeImg = create_element("img", true, ["src" => "../resources/challenge.png", "class" => "bar"]);
            $challengeIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("Challenge"),
                "contents" => $challengeImg]);

            $grid = create_element("div", false, ["class" => "barGrid barBorder"]);
            add_to_element($grid, $createIcon);
            add_to_element($grid, $listIcon);
            add_to_element($grid, $statsIcon);
            add_to_element($grid, $challengeIcon);
            close_element($grid);

            echo $grid;
        }
    }

?>