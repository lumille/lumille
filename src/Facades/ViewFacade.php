<?php


namespace Lumille\Facades;


use Illuminate\Support\Facades\Facade;
use Lumille\App\Config;
use Lumille\View\View;

class ViewFacade extends Facade
{
    protected static function getFacadeAccessor ()
    {
        return new View(app()->getPath('path.view'), app()->getPath('path.cache'));
    }
}