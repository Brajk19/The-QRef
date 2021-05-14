<?php

    namespace view;

    use router\Router;

    class MainPageHeaderEmpty{
        public static function printHTML(): void{
            $homeImg = create_element("img", true, ["src" => "../../resources/home.png", "height" => "70px",
                "class" => "headerIcon"]);
            $homeIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("MainPage"),
                "contents" => $homeImg]);


            $name = create_element("div", true, ["class" => "fullName", "contents" => "Welcome, anonymous!"]);

            $grid = create_element("div", false, ["class" => "gridHeader headerBorder"]);
            add_to_element($grid, $name);
            add_to_element($grid, $homeIcon);
            close_element($grid);

            echo $grid;
        }
    }

?>