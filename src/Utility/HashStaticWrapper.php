<?php


namespace Lumille\Utility;


class HashStaticWrapper
{
    protected static $hash = [];

    public static function all ()
    {
        return static::$hash;
    }

    public static function get ($key, $default = null)
    {
        return Hash::get(static::$hash, $key, $default);
    }

    public static function extract ($path)
    {
        return Hash::extract(static::$hash, $path);
    }

    public static function combine ($keyPath, $valuePath = null, $groupPath = null)
    {
        return Hash::combine(static::$hash, $keyPath, $valuePath, $groupPath);
    }

    public static function format (array $paths, $format)
    {
        return Hash::format(static::$hash, $paths, $format);
    }

    public static function check (string $path = null )
    {
        return Hash::check(static::$hash, $path);
    }

    public static function map ($path, $callable)
    {
        return Hash::map(static::$hash, $callable);
    }

    public static function reduce ($path, $callable)
    {
        return Hash::reduce(static::$hash, $path, $callable);
    }

    public static function apply ($path, $callable)
    {
        return Hash::apply(static::$hash, $path, $callable);
    }

    public static function sort ($path, $dir, $type = 'regular')
    {
        return Hash::sort(static::$hash, $path, $dir, $type);
    }

    public static function insert ($path, $values = null)
    {
        $result = Hash::insert(static::$hash, $path, $values);
        static::$hash = $result;
        return $result;
    }

    public static function set ($path, $values = null)
    {
        static::insert($path, $values);
    }

    public static function remove ($path)
    {
        return Hash::remove(static::$hash, $path);
    }

    public static function nest (array $options = [])
    {
        return Hash::nest(static::$hash, $options);
    }

    public static function diff (array $compare)
    {
        return Hash::diff(static::$hash, $compare);
    }

    public static function mergeDiff (array $compare)
    {
        return Hash::mergeDiff(static::$hash, $compare);
    }

    public static function normalize ($assoc = true)
    {
        return Hash::normalize(static::$hash, $assoc);
    }

    public static function contains (array $needle)
    {
        return Hash::contains(static::$hash, $needle);
    }

    public static function filter ($callable = ['Hash', 'filter'])
    {
        return Hash::filter(static::$hash, $callable);
    }

    public static function flatten ($separator = '.')
    {
        return Hash::flatten(static::$hash, $separator);
    }

    public static function expand ($separator = '.')
    {
        return Hash::expand(static::$hash, $separator);
    }

    public static function merge (array $merge, array $n = [])
    {
        return Hash::merge(static::$hash, $merge, $n);
    }

    public static function numeric ()
    {
        return Hash::numeric(static::$hash);
    }

    public static function dimensions ()
    {
        return Hash::dimensions(static::$hash);
    }

    public static function maxDimensions ()
    {
        return Hash::maxDimensions(static::$hash);
    }
}