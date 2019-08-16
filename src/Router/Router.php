<?php


namespace Lumille\Router;


use AltoRouter;
use Lumille\Singleton;

class Router extends Singleton
{

    private static function newRoute ()
    {
        return new Route();
    }

    public static function get ($url, $callable, $name = null)
    {
        static::newRoute()->get($url, $callable, $name);
    }

    public static function post ($url, $callable, $name = null)
    {
        static::newRoute()->post($url, $callable, $name);
    }

    public static function put ($url, $callable, $name = null)
    {
        static::newRoute()->put($url, $callable, $name);
    }

    public static function patch ($url, $callable, $name = null)
    {
        static::newRoute()->patch($url, $callable, $name);
    }

    public static function delete ($url, $callable, $name = null)
    {
        static::newRoute()->delete($url, $callable, $name);
    }

    public static function all ($url, $callable, $name)
    {
        static::newRoute()->all($url, $callable, $name);
    }

    public static function group ($name, $callback)
    {
        $route = new Route();
        $route->setGroup($name);

        \call_user_func($callback, $route);
    }

    public static function route($name)
    {
        $namedRoutes = static::getNamedRoutes();
        if (\array_key_exists($name, $namedRoutes)) {
            return $namedRoutes[$name];
        }
    }

    public static function getRoutes ()
    {
        return RouteCollection::getListRoutes();
    }

    public static function getNamedRoutes ()
    {
        return RouteCollection::getListNamedRoutes();
    }

    public static function boot ()
    {
        $methods = static::getRoutes();
        $router = new AltoRouter();

        foreach ($methods as $method => $routes) {
            foreach ($routes as $route) {
                $router->map($method, $route[0], $route[1]);
            }
        }

        $match = $router->match();

        if( is_array($match) ) {
            if (is_string($match['target'])) {
                list($controller, $method) = explode('::', $match['target']);
                $controller = "App\\Controller\\" . $controller;
                $controller = new $controller;
                call_user_func_array([$controller, $method], $match['params']);
            } elseif (is_callable($match['target'])) {
                call_user_func_array( $match['target'], $match['params'] );
            }
        } else {
            // no route was matched
            $controller = "App\\Controller\\ErrorController";
            $controller = new $controller();
            call_user_func([$controller, 'error404']);
        }
    }

}