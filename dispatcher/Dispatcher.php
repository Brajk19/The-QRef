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

        public function dispatch(): void {
            $route = $_SERVER["REQUEST_URI"];

            if($route === "/"){
                if(isset($_COOKIE["sessionID"])){
                    if(Cookie::checkSessionID($_COOKIE["sessionID"])){
                        $route = Router::getInstance();
                        $nextPage = $route->getRoute("MainPage");
                        header("Location: $nextPage");
                    }
                    else{
                        //nevaljan cookie
                            Cookie::deleteSession($_COOKIE["sessionID"]);
                            Cookie::deleteCookie();
                    }
                }
                $route = Router::getInstance()->getRoute("Login");
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