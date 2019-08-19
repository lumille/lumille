<?php


namespace Lumille\Foundation;

use Lumille\Utility\HashWrapper;

class Config extends HashWrapper
{
    protected $hash;

    public function __construct ($configs)
    {
        $this->hash = $configs;
    }
}