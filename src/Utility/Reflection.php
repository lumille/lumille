<?php


namespace Lumille\Utility;


class Reflection
{
    public static function parseAgrs ($callable)
    {
        $args = [];

        if (!\is_array($callable) && \is_callable($callable)) {
            $x = new \ReflectionFunction($callable);
        } else {
            list($controller, $method) = $callable;
            $x = new \ReflectionMethod($controller, $method);
        }
        $params = $x->getParameters();

        foreach ($params as $param) {
            $args[] = $param->getName();
        }

        return $args;
    }
}