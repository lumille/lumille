<?php


namespace Lumille\Facades;


use Illuminate\Support\Facades\Facade;
use Lumille\Router\Router;

class RouterFacade extends Facade
{
    protected static function getFacadeAccessor ()
    {
        return new Router();
    }
}