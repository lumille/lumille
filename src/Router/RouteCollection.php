<?php


namespace Lumille\Router;


use Lumille\Singleton;

class RouteCollection extends Singleton
{
    protected $routes = [];

    protected $namedRoutes = [];

    static function push ($method, $url, $callable, $name)
    {
        $method = \mb_convert_case($method, \MB_CASE_UPPER);
        self::getInstance()->routes[$method][] = [$url, $callable];

        if ($name) {
            self::getInstance()->namedRoutes[$name] = $url;
        }
    }

    static public function getListRoutes ()
    {
        return static::getInstance()->routes;
    }

    static public function getListNamedRoutes ()
    {
        return static::getInstance()->namedRoutes;
    }
}