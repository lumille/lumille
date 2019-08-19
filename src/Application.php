<?php


namespace Lumille;


use Lumille\Facades\AliasLoader;
use Lumille\Foundation\Container;
use Lumille\Routing\RouterException;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * @var array
     */
    protected $providers;

    /**
     * @var Container
     */
    protected $dic;

    public function __construct ($rootDir)
    {
        $this->rootDir = $rootDir;
        $this->dic = new Container();
        $this->register();

    }

    private function register ()
    {
        $this->loadConfigs();
        $this->registerFacadeAliases();
        $this->registerProviders();
    }

    private function registerFacadeAliases ()
    {
        AliasLoader::getInstance($this->configs['app']['alias'])->register();
    }

    private function registerProviders ()
    {
        $providers = $this->configs['app']['providers'];

        foreach ($providers as $provider) {
            $class = new $provider($this);
            $this->providers[] = $class;
            \call_user_func([$class, 'register']);
        }

    }

    private function bootProviders ()
    {
        foreach ($this->providers as $provider) {
            \call_user_func([$provider, 'boot']);
        }
    }

    private function boot ()
    {
        $this->bootProviders();
        $this->loadRoutes();

    }

    private function loadRoutes ()
    {
        $routePath = $this->getPath('path.route');
        $files = array_diff(\scandir($routePath), ['.', '..']);
        foreach ($files as $file) {
            require_once($routePath . $file);
        }
    }

    public function run ()
    {
        $this->boot();

        try {
            $res = \Route::run();
            $response = new Response($res);
        } catch (RouterException $e) {
            dd($e);
            $controller = "App\\Controller\\ErrorController";
            $method = "error404";

            $response = new Response(
                call_user_func([new $controller, $method]),
                404);
        }

        return $response->send();

    }

    /**
     * @return mixed
     */
    public function getRootDir ()
    {
        return $this->rootDir;
    }

    public function getPath ($name, $default = null)
    {
        return $this->getRootDir() . '/' . \Config::get($name);
    }

    private function loadConfigs ()
    {
        $configPath = $this->getRootDir() . '/config/';
        $configs = array_diff(\scandir($configPath), ['.', '..']);
        foreach ($configs as $config) {
            $filename = \pathinfo($config, \PATHINFO_FILENAME);
            $val = require_once($configPath . $config);
            $this->configs[$filename] = $val;
        }
    }

    public function singleton ($name, $callback)
    {
        $this->dic->singleton($name, $callback);
    }

    public function factory ($name, $callback)
    {
        $this->dic[$name] = $this->dic->factory($callback);
    }

    /**
     * @return mixed
     */
    public function getDic ($name = null)
    {

        if ($name && isset($this->dic[$name])) {
            return $this->dic[$name];
        }
        return $this->dic;
    }

    /**
     * @return array
     */
    public function getConfigs (): array
    {
        return $this->configs;
    }

    public function getLocale ()
    {
        return \Config::get('app.locale');
    }

}