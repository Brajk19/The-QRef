<?php

    namespace view;

    use model\User;
    use router\Router;

    class MainPageHeader {
        public static function printHTML(): void{
            $fullName = htmlentities(User::getFullName());

            $settingsImg = create_element("img", true, ["src" => "../resources/settings.png", "height" => "70px",
                    "class" => "headerIcon"]);
            $settingsIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("Settings"),
                    "contents" => $settingsImg]);

            $homeImg = create_element("img", true, ["src" => "../resources/home.png", "height" => "70px",
                    "class" => "headerIcon"]);
            $homeIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("MainPage"),
                    "contents" => $homeImg]);

            $logoutImg = create_element("img", true, ["src" => "../resources/logout.png", "height" => "70px",
                    "class" => "headerIcon"]);
            $logoutIcon = create_element("a", true, ["href" => Router::getInstance()->getRoute("Logout"),
                    "contents" => $logoutImg]);

            $name = create_element("div", true, ["class" => "fullName", "contents" => "Welcome, $fullName!"]);

            $grid = create_element("div", false, ["class" => "gridHeader headerBorder"]);
            add_to_element($grid, $name);
            add_to_element($grid, $settingsIcon);
            add_to_element($grid, $homeIcon);
            add_to_element($grid, $logoutIcon);
            close_element($grid);

            echo $grid;
        }
    }

?>