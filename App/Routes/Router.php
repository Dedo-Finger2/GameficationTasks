<?php

namespace App\Routes;

use App\Controllers\RouteErrorHandleController;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    private static array $routes;

    public static function add(string $method, string $uri, array $controller)
    {
        self::$routes[] = [$method, $uri, $controller];
    }

    public static function run()
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $r) {
            foreach (self::$routes as $route) {
                $r->addRoute(...$route);
            }
        });
        
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        self::handle($routeInfo);
    }

    private static function handle(array $routeInfo)
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:        
                call_user_func_array([new RouteErrorHandleController, 'notFound'], []);
        
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                call_user_func_array([new RouteErrorHandleController, 'notAllowed'], []);
        
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
        
                [, [$controller, $method], $vars] = $routeInfo;
        
                call_user_func_array([new $controller, $method], $vars);
        
                break;
        }
    }
}
