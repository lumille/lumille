<?php


namespace Lumille\Facades;


class RequestFacades extends Facade
{
    public static function getFacadeAccessor ()
    {
        return 'request';
    }
}