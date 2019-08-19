<?php


namespace Lumille\Facades;


class ConfigFacade extends Facade
{
    protected static function getFacadeAccessor ()
    {
        return 'config';
    }
}