<?php


namespace Lumille\Facades;


use Illuminate\Support\Facades\Facade;
use Lumille\App\Config;
use Lumille\View\View;

class ViewFacade extends Facade
{
    private static $instance;

    protected static function getFacadeAccessor ()
    {
        if (self::$instance === null) {
            self::$instance = new View(app()->getPath('path.view'), app()->getPath('path.cache'));
        }
        return self::$instance;
    }
}