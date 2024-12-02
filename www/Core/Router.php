<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function __construct($routesFile)
    {
        // On recupere les routes depuis le fichier yaml.
        $this->routes = yaml_parse_file($routesFile);
    }

    public function handleRequest()
    {
        $requestUri = $this->cleanUri($_SERVER['REQUEST_URI']);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $path => $route) {
            if ($path === $requestUri && in_array($requestMethod, $route['methods'])) {
                $controllerName = 'App\\Controllers\\' . $route['controller'];
                $actionName = $route['action'];
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $actionName)) {
                        $controller->$actionName();
                        return;
                    } else {
                        http_response_code(404);
                        echo "404 Not Found: Method $actionName not found in controller $controllerName";
                        return;
                    }
                } else {
                    http_response_code(404);
                    echo "404 Not Found: Controller $controllerName not found";
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function cleanUri($uri)
    {
        $uri = strtok(strtolower($uri), "?");
        return (strlen($uri) > 1) ? rtrim($uri, "/") : $uri;
    }
}