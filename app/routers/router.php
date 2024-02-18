<?php
namespace routers;

class Router
{
    private $routes = [];

    public function addRoute($uri, $controllerMethod)
    {
        $this->routes[$uri] = $controllerMethod;
    }

    public function handleRequest()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (array_key_exists($requestUri, $this->routes) &&
            $_SERVER['REQUEST_METHOD'] == (strpos($requestUri, 'Action') ? 'POST' : 'GET')) {
            $controllerMethod = $this->routes[$requestUri];
            call_user_func($controllerMethod);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

?>
