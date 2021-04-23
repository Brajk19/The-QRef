<?php
    namespace dispatcher;

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
                /*  TODO
                 * provjeri ako je vec ulogiran, u tom slucaju ga salji na homepage
                 */

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