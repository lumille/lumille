<?php


namespace Lumille;

use Lumille\App\Config;
use Lumille\App\Session;
use Lumille\Facades\AliasLoader;
use Lumille\Http\Request;
use Lumille\Routing\Router;
use Lumille\Routing\RouterException;
use Symfony\Component\HttpFoundation\Response;

class App
{
    protected $router;

    public function run ()
    {
        $this->loadConfigs();
        AliasLoader::getInstance($this->config('app.alias'))->register();
        Session::init($this->config('session'));
        Session::start();

        $this->router = new Router($this->config('app.controllerPath'), $_SERVER['REQUEST_URI']);
        $this->loadRoutes();

        try {
            $html = $this->router->run();
            $response = new Response($html);
        } catch (RouterException $e) {
            $controller = "App\\Controller\\ErrorController";
            $method = "error404";

            $response = new Response(
                call_user_func([new $controller, $method]),
                404);
        }

        return $response->send();
    }

    private function loadConfigs ()
    {
        $configPath = $this->root() . 'config/';
        $configs = array_diff(\scandir($configPath), ['.', '..']);
        foreach ($configs as $config) {
            $filename = \pathinfo($config, \PATHINFO_FILENAME);
            $val = require_once($configPath . $config);
            Config::insert($filename, $val);
        }
    }

    private function loadRoutes ()
    {
        $router = $this->router;
        $routePath = $this->getPath('path.route');
        $files = array_diff(\scandir($routePath), ['.', '..']);
        foreach ($files as $file) {
            require_once($routePath . $file);
        }
    }

    public function config($path, $default = null)
    {
        return Config::get($path, $default);
    }

    public function root ()
    {
        return Request::documentRoot() . '/../';
    }

    public function getPath($name)
    {
        return $this->root() . $this->config($name);
    }

    public function getLocale()
    {
        return $this->config('app.locale');
    }

    /**
     * @return mixed
     */
    public function getRouter ()
    {
        return $this->router;
    }

}