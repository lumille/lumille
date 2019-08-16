<?php


namespace Lumille;


abstract class Singleton
{

    protected function __construct ()
    {
    }

    final public static function getInstance()
    {
        static $instances = array();

        $calledClass = get_called_class();

        if (!isset($instances[$calledClass]))
        {
            $cls = new $calledClass();

            if (\method_exists($cls, 'init')) {
                $cls->init();
            }

            $instances[$calledClass] = $cls;

        }

        return $instances[$calledClass];
    }

    final private function __clone()
    {
    }
}