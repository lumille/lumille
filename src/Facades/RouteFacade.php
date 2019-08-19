<?php


namespace Lumille\Facades;


class RouteFacade extends Facade
{
    protected static function getFacadeAccessor ()
    {
        return 'route';
    }
}