<?php


namespace Lumille\Utility;


abstract class HashWrapper
{
    protected $hash = [];

    public function all ()
    {
        return $this->hash;
    }

    public function get ($key, $default = null)
    {
        return Hash::get($this->hash, $key, $default);
    }

    public function extract ($path)
    {
        return Hash::extract($this->hash, $path);
    }

    public function combine ($keyPath, $valuePath = null, $groupPath = null)
    {
        return Hash::combine($this->hash, $keyPath, $valuePath, $groupPath);
    }

    public function format (array $paths, $format)
    {
        return Hash::format($this->hash, $paths, $format);
    }

    public function check (string $path = null)
    {
        return Hash::check($this->hash, $path);
    }

    public function map ($path, $callable)
    {
        return Hash::map($this->hash, $callable);
    }

    public function reduce ($path, $callable)
    {
        return Hash::reduce($this->hash, $path, $callable);
    }

    public function apply ($path, $callable)
    {
        return Hash::apply($this->hash, $path, $callable);
    }

    public function sort ($path, $dir, $type = 'regular')
    {
        return Hash::sort($this->hash, $path, $dir, $type);
    }

    public function insert ($path, $values = null)
    {
        $result = Hash::insert($this->hash, $path, $values);
        $this->hash = $result;
        return $result;
    }

    public function set ($path, $values = null)
    {
        $this->insert($path, $values);
    }

    public function remove ($path)
    {
        return Hash::remove($this->hash, $path);
    }

    public function nest (array $options = [])
    {
        return Hash::nest($this->hash, $options);
    }

    public function diff (array $compare)
    {
        return Hash::diff($this->hash, $compare);
    }

    public function mergeDiff (array $compare)
    {
        return Hash::mergeDiff($this->hash, $compare);
    }

    public function normalize ($assoc = true)
    {
        return Hash::normalize($this->hash, $assoc);
    }

    public function contains (array $needle)
    {
        return Hash::contains($this->hash, $needle);
    }

    public function filter ($callable = ['Hash', 'filter'])
    {
        return Hash::filter($this->hash, $callable);
    }

    public function flatten ($separator = '.')
    {
        return Hash::flatten($this->hash, $separator);
    }

    public function expand ($separator = '.')
    {
        return Hash::expand($this->hash, $separator);
    }

    public function merge (array $merge, array $n = [])
    {
        return Hash::merge($this->hash, $merge, $n);
    }

    public function numeric ()
    {
        return Hash::numeric($this->hash);
    }

    public function dimensions ()
    {
        return Hash::dimensions($this->hash);
    }

    public function maxDimensions ()
    {
        return Hash::maxDimensions($this->hash);
    }
}