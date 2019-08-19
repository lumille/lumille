<?php


namespace Lumille\Facades;

use Lumille\View\View;

class ViewFacade extends Facade
{

    protected static function getFacadeAccessor ()
    {
        return 'view';
    }
}