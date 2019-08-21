<?php


namespace Lumille;


use Lumille\Facades\AliasLoader;
use Lumille\Foundation\Container;
use Lumille\Http\Request;
use Lumille\Routing\RouterException;
use Lumille\Utility\Reflection;
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

    /**
     * @var Request
     */
    private $request;

    private $response;

    public function __construct ($rootDir)
    {
        $this->rootDir = $rootDir;
        $this->dic = new Container();
        $this->register();
        $this->request = new Request();
        $this->response = new Http\Response();
        $this->dic['request'] = $this->request;
        $this->dic['response'] = $this->response;

    }

    /**
     * Register action
     */
    private function register ()
    {
        $this->loadConfigs();
        $this->registerFacadeAliases();
        $this->registerProviders();
    }

    /**
     * Load Configs
     */
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

    /**
     * @return mixed
     */
    public function getRootDir ()
    {
        return $this->rootDir;
    }

    /**
     * Register all Facades
     */
    private function registerFacadeAliases ()
    {
        AliasLoader::getInstance($this->configs['app']['alias'])->register();
    }

    /**
     * Register all providers
     */
    private function registerProviders ()
    {
        $providers = $this->configs['app']['providers'];

        foreach ($providers as $provider) {
            $class = new $provider($this);
            $this->providers[] = $class;
            \call_user_func([$class, 'register']);
        }
    }

    /**
     * @return Response
     */
    public function run ()
    {
        $this->boot();

        try {
            list($callable, $_args) = \Route::run();

            if (!\is_callable($callable)) {
                @list($controller, $method) = explode('::', $callable);
                $controller = \Config::get('app.namespaces.controller') . $controller;
                $controller = new $controller;
                $callable = [$controller, $method];
            }

            $params = Reflection::parseAgrs($callable);

            $args = [];
            foreach ($params as $param) {
                if (isset($_args[$param])) {
                    $args[$param] = $_args[$param];
                }
            }

            $response = \call_user_func_array($callable, $args);

            if (!($response instanceof Response)) {
                $response = \Response::setHeaders('Content-Type', 'application/json')
                    ->setContent($response);
            }

        } catch (RouterException $e) {
            $controller = "App\\Controller\\ErrorController";
            $method = "error404";

            $response = call_user_func([new $controller, $method]);
            $response->setStatusCode(404);
        }

        return $response->send();

    }

    /**
     * Boot
     */
    private function boot ()
    {
        $this->bootProviders();
        $this->loadRoutes();

    }

    /**
     * Boot Providers
     */
    private function bootProviders ()
    {
        foreach ($this->providers as $provider) {
            \call_user_func([$provider, 'boot']);
        }
    }

    /**
     * Load all routes
     */
    private function loadRoutes ()
    {
        $routePath = $this->getPath('path.route');
        $files = array_diff(\scandir($routePath), ['.', '..']);
        foreach ($files as $file) {
            require_once($routePath . $file);
        }
    }

    /**
     * Get Path from root directory
     * @param $name
     * @param null $default
     * @return string
     */
    public function getPath ($name, $default = null)
    {
        return $this->getRootDir() . '/' . \Config::get($name);
    }

    /**
     * Create singleton on container DIC
     * @param $name
     * @param $callback
     */
    public function singleton ($name, $callback)
    {
        $this->dic->singleton($name, $callback);
    }

    /**
     * Create a factory container DIC
     * @param $name
     * @param $callback
     */
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

    /**
     * @return mixed
     */
    public function getLocale ()
    {
        return \Config::get('app.locale');
    }

    /**
     * @return Request
     */
    public function getRequest (): Request
    {
        return $this->request;
    }

}