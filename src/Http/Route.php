<?php
namespace Nopel\Http;

use Nopel\View\View;

class Route 
{
    public static array $routes = [];

    protected Request $request;
    protected Response $response;

    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public static function get($route, callable|array|string $action)
    {
        Self::$routes['get'][$route] = $action;
    }

    public static function post($route, callable|array|string $action)
    {
        Self::$routes['post'][$route] = $action;
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();

        $action = Self::$routes[$method][$path] ?? FALSE;

        if(!array_key_exists($path, Self::$routes[$method]))
        // if(!$action)
        {
            return View::makeError('404');
        }

        // 404 handling

        if(is_callable($action))
        {
            call_user_func_array($action, []);
        }

        if(is_array($action))
        {
            // $controller = new $action[0];
            call_user_func_array([new $action[0], $action[1]], []);
        }
    }
}