<?php


namespace Lumille\View;


use eftec\bladeone\BladeOne;
use Lumille\Http\Request;

class View
{

    protected $blade;

    public function __construct ($views, $cache, $mode = BladeOne::MODE_AUTO)
    {
        $blade = new BladeOne($views, $cache, $mode);
        $blade->setBaseUrl(Request::getDomain());

        $this->blade = $blade;
        return $this->blade;
    }

    public function share ($name, $value = null)
    {
        if (!is_array($name)) {
            $name = [$name => $value];
        }

        foreach ($name as $key => $value) {
            $this->blade->share($key, $value);
        }
    }

    public function render($view, array $params = [])
    {
        return $this->blade->run($view, $params);
    }
}