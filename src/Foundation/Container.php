<?php


namespace Lumille\Foundation;


class Container extends \Pimple\Container
{
    public function singleton ($name, $class)
    {
        if (\is_callable($class)) {
            $this[$name] = \call_user_func_array($class, [$this]);
        } else {
            $this[$name] = function () use ($class) {
                return new $class;
            };
        }

        return $this;
    }
}