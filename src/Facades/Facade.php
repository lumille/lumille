<?php


namespace Lumille\Facades;


class Facade extends \Illuminate\Support\Facades\Facade
{

    public static function getFacadeRoot ()
    {
        return app(static::getFacadeAccessor());
    }

}