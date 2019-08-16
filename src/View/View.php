<?php


namespace Lumille\View;


use eftec\bladeone\BladeOne;
use Lumille\Http\Request;
use Lumille\Singleton;

class View
{

    protected static $blade;

    public static function boot ($views, $cache, $mode = BladeOne::MODE_AUTO)
    {
        $blade = new BladeOne($views, $cache, $mode);
        $blade->setBaseUrl(Request::getDomain());

        static::$blade = $blade;
        return static::$blade;
    }

    public static function share ($name, $value = null)
    {
        if (!is_array($name)) {
            $name = [$name => $value];
        }

        foreach ($name as $key => $value) {
            static::$blade->share($key, $value);
        }
    }

    public static function render($view, array $params = [])
    {
        return static::$blade->run($view, $params);
    }
}