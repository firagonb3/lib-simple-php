<?php

namespace lib;

use ReflectionFunction;
use ReflectionMethod;

class Router
{
    private static $router = [];
    private static $error404 = null;

    public static function get($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$router['GET'][$uri] = $callback;
    }

    public static function post($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$router['POST'][$uri] = $callback;
    }

    public static function patch($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$router['PATCH'][$uri] = $callback;
    }

    public static function put($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$router['PUT'][$uri] = $callback;
    }

    public static function delete($uri, $callback)
    {
        $uri = trim($uri, '/');
        self::$router['DELETE'][$uri] = $callback;
    }

    public static function setError404($uri) 
    {
        self::$error404 = $uri;
    }

    public static function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        if (strpos($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        foreach (self::$router[$method] as $route => $callback) {

            if (strpos($route, ':') !== false) {
                $route = preg_replace('#:[a-zA-z0-9]+#', '([a-zA-z0-9]+)', $route);
            }

            if (preg_match("#^$route$#", $uri, $matches)) {
                $params = array_slice($matches, 1);

                 if (is_callable($callback)) {
                    $refCallback = new ReflectionFunction($callback);
                    $parameters = $refCallback->getParameters();

                    if (isset($parameters[0]) && $parameters[0]->getClass() && $parameters[0]->getClass()->name === Request::class) {
                        $res = $callback(new Request, ...$params);
                    } else {
                        $res = $callback(...$params);
                    }
                }

                if (is_array($callback)) {
                    $controller = new $callback[0];
                    $refCallback = new ReflectionMethod($controller, $callback[1]);
                    $parameters = $refCallback->getParameters();

                    if (isset($parameters[0]) && $parameters[0]->getClass() && $parameters[0]->getClass()->name === Request::class) {
                        $res = $controller->{$callback[1]}(new Request, ...$params);
                    } else {
                        $res = $controller->{$callback[1]}(...$params);
                    }
                }

                if (is_array($res) || is_object($res)) {
                    header('Content-Type: application/json');
                    echo json_encode($res);
                } else {
                    echo $res;
                }

                return;
            }
        }
        echo self::$error404 === null ? '404 Not Found' : Render::view(self::$error404);
    }
}
