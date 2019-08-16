<?php


namespace Lumille\Router;


use AltoRouter;
use Lumille\Singleton;

class Router
{

    private function newRoute ()
    {
        return new Route();
    }

    public function get ($url, $callable, $name = null)
    {
        $this->newRoute()->get($url, $callable, $name);
    }

    public function post ($url, $callable, $name = null)
    {
        $this->newRoute()->post($url, $callable, $name);
    }

    public function put ($url, $callable, $name = null)
    {
        $this->newRoute()->put($url, $callable, $name);
    }

    public function patch ($url, $callable, $name = null)
    {
        $this->newRoute()->patch($url, $callable, $name);
    }

    public function delete ($url, $callable, $name = null)
    {
        $this->newRoute()->delete($url, $callable, $name);
    }

    public function all ($url, $callable, $name)
    {
        $this->newRoute()->all($url, $callable, $name);
    }

    public function group ($name, $callback)
    {
        $route = new Route();
        $route->setGroup($name);

        \call_user_func($callback, $route);
    }

    public function route($name)
    {
        $namedRoutes = $this->getNamedRoutes();
        if (\array_key_exists($name, $namedRoutes)) {
            return $namedRoutes[$name];
        }
    }

    public function getRoutes ()
    {
        return RouteCollection::getListRoutes();
    }

    public function getNamedRoutes ()
    {
        return RouteCollection::getListNamedRoutes();
    }

    public function run ()
    {
        $methods = $this->getRoutes();
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