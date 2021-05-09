<?php
    namespace dispatcher;

    use model\Cookie;
    use router\Router;

    class Dispatcher {
        private static ?Dispatcher $object = NULL;

        private function __construct() {}
        private function __clone() {}

        public static function getInstance(): Dispatcher { //singleton
            if(is_null(self::$object)){
                self::$object = new Dispatcher();
            }

            return self::$object;
        }

        /**
         * If user is not logged in, he will be only allowed to access pages for logging in / registration
         * and he will be able to solve quiz if he has URL of quiz.
         * Every other request will be rerouted to login page.
         */
        public function dispatch(): void {
            $route = $_SERVER["REQUEST_URI"];
            $allowedRoutes = ["Login", "Logout", "VerifyLogin", "Register", "VerifyRegistration",
                "SuccessfulRegistration"]; //allowed routed for user that's not logged in. TODO add route for quiz later

            if(isset($_COOKIE["sessionID"])){
                if(!Cookie::checkSessionID($_COOKIE["sessionID"])){
                    Cookie::deleteSession($_COOKIE["sessionID"]);
                    Cookie::deleteCookie();

                    $nextPage = Router::getInstance()->getRoute("Login");
                    header("Location: $nextPage");
                    die();
                }
                else {
                    $validRoute = false;
                    foreach (Router::getInstance()->getAllRoutes() as $routeName){
                        if($_SERVER["REQUEST_URI"] === Router::getInstance()->getRoute($routeName)){
                            $validRoute = true;
                            break;
                        }
                    }

                    if(!$validRoute){
                        $nextPage = Router::getInstance()->getRoute("MainPage");
                        header("Location: $nextPage");
                        die();
                    }
                }
            }
            else {
                $found = false;
                foreach($allowedRoutes as $r){
                    if($_SERVER["REQUEST_URI"] === Router::getInstance()->getRoute($r)){
                        $found = true;
                        break;
                    }
                }

                if(!$found){
                    $nextPage = Router::getInstance()->getRoute("Login");
                    header("Location: $nextPage");
                    die();
                }
            }

            $route = substr($route, 1);
            $arr = explode("/", $route);
            $controller = $arr[0];
            $action = $arr[1];

            if(count($arr) === 2){
                $class = "\\controller\\$controller";
                $object = new $class;
            }

            $object->$action();
        }
    }

?>