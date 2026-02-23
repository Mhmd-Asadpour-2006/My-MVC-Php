<?php

namespace Core\Router;

class Router
{
    private $current_route;

    private $method_field;

    private $routes;

    private $params = [];

    public function __construct(){
        $this->current_route = explode('/', CURRENT_ROOT);
        global $routes;
        $this->routes = $routes;
        $this->method_field = $this->methodField();
    }

    public function methodField()
    {
        $method_field = strtolower($_SERVER['REQUEST_METHOD']);
        if($method_field == 'post'){
            if ($_POST['method'] == 'put') {
                $method_field = 'put';
            }
            else if ($_POST['method'] == 'delete') {
                $method_field = 'delete';
            }
        }
        return $method_field;
    }

    public function checkRoute()
    {
        $reserved_routes = $this->routes[$this->method_field];

        foreach ($reserved_routes as $reserved_route) {

            $reserved_route_array = explode('/', $reserved_route['route']);

            if (sizeof($reserved_route_array) !== sizeof($this->current_route)) {
                continue;
            }

            $this->params = [];
            $isMatched = true;

            foreach ($reserved_route_array as $key => $value) {

                if ($value === $this->current_route[$key]) {
                    continue;
                }

                if (substr($value,0,1) == '{' &&
                    substr($value,-1) == '}'
                ) {
                    $this->params[] = $this->current_route[$key];
                }
                else {
                    $isMatched = false;
                    break;
                }
            }

            if ($isMatched) {

                $controller = "\\App\\Http\\Controllers\\".$reserved_route['controller'];
                $object = new $controller();

                if (!method_exists($object,$reserved_route['method'])) {
                    continue;
                }

                call_user_func_array(
                    [$object,$reserved_route['method']],
                    $this->params
                );

                return;
            }
        }

        echo "<h1> Controller Not Found </h1>";
    }
}