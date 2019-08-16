<?php


namespace Lumille;

use Lumille\App\Config;
use Lumille\App\Session;
use Lumille\Http\Request;
use Lumille\Router\Router;
use Lumille\View\View;

class App
{

    public function run ()
    {
        $this->loadConfigs();
        $this->loadRoutes();
        Session::init($this->config('session'));
        Session::start();
        View::boot($this->getPath('path.view'), $this->getPath('path.cache'));
        Router::boot();;
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

}