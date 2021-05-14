<?php
    namespace router;

    use Symfony\Component\Yaml\Yaml;

    require_once "./vendor/autoload.php";

    final class Router {
        private static ?Router $object = NULL;

        private function __construct(
            private array $routes = []
        ) {
            $this->routes = Yaml::parseFile("./router/routes.yaml");
        }

        private function __clone() {}

        public static function getInstance(): Router { //singleton
            if(is_null(self::$object)){
                self::$object = new Router();
            }

            return self::$object;
        }

        public function getRoute(string $name, int $id = 1): string {
            $route = $this->routes[$name];

            if(isset($route["id"])){
                $route["id"] = str_replace("<id>", strval($id), $route["id"]);

                return "/" . $route["controller"] . "/" . $route["action"] . "/" . $route["id"];
            }

            return "/" . $route["controller"] . "/" . $route["action"];
        }

        public function getAllRoutes(): array{
            return array_keys($this->routes);
        }
    }

?>