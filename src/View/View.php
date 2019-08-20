<?php


namespace Lumille\View;


use eftec\bladeone\BladeOne;

class View
{

    protected $blade;

    public function __construct ($views, $cache, $mode = BladeOne::MODE_AUTO)
    {
        $blade = new BladeOne($views, $cache, $mode);
        $blade->setBaseUrl(\Request::getSchemeAndHttpHost());

        $this->blade = $blade;
        return $this->blade;
    }

    public function __call ($name, array $args = [])
    {
        return \call_user_func_array([$this->blade, $name], $args);
    }

    public function make($view, array $params = [])
    {
        return $this->blade->run($view, $params);
    }
}