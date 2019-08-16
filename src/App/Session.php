<?php


namespace Lumille\App;


use Lumille\Utility\HashWrapper;

class Session extends HashWrapper
{
    static protected $config = [];

    public static function getName ()
    {
        return \session_name();
    }

    public static function setName ($name)
    {
        \session_name($name);
    }

    public static function start ()
    {
        \session_start(static::$config);
        static::$hash = &$_SESSION;
    }

    public static function init (array $config = [])
    {
        static::$config = $config;
    }

    public static function destroy ()
    {
        \session_destroy();
        static::start();
    }

    public static function reset ()
    {
        \session_reset();
        static::$hash = &$_SESSION;
    }
}