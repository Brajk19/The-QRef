<?php
    namespace dispatcher;

    use model\Cookie;
    use router\Router;

    class Dispatcher {
        private static ?Dispatcher $object = NULL;
        private array $arr;

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
                "SuccessfulRegistration", "SolveQuizAnonymous", "VerifyAnswers"];    //allowed routes if you are not logged in

            $route = substr($route, 1);
            $this->arr = explode("/", $route);

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
                        $validRoute = $this->checkRoute($routeName);

                        if($validRoute) break;
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
                    $found = $this->checkRoute($r);

                    if($found) break;
                }

                if(!$found){
                    $nextPage = Router::getInstance()->getRoute("Login");
                    header("Location: $nextPage");
                    die();
                }
            }


            $controller = $this->arr[0];
            $action = $this->arr[1];

            $class = "\\controller\\$controller";

            if(count($this->arr) === 2){
                $object = new $class;
            }
            else{
                $id = intval($this->arr[2]);
                $object = new $class($id);
            }

            $object->$action();
        }

        private function checkRoute(string $routeName): bool {
            if(count($this->arr) === 3){
                if($_SERVER["REQUEST_URI"] === Router::getInstance()->getRoute($routeName, intval($this->arr[2]))){
                    return true;
                }
            }
            else if($_SERVER["REQUEST_URI"] === Router::getInstance()->getRoute($routeName)){
                return true;
            }

            return false;
        }
    }

?>